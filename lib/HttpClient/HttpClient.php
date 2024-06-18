<?php

namespace Fiserv\HttpClient;

use CurlHandle;
use Exception;
use Fiserv\Exception\BadRequestException;
use Fiserv\Exception\CurlRequestException;
use Fiserv\Exception\ServerException;
use Fiserv\Models\FiservObject;
use Fiserv\Models\ResponseInterface;
use Fiserv\Models\ValidationInterface;

abstract class HttpClient
{
    public const VERSION = '0.1.4';
    public const USER = '';
    private const DOMAIN = 'https://prod.emea.api.fiservapps.com/';
    protected string $endpointRoot;
    protected array $apiConfig;
    private string $url;
    private $curl;

    private const DEFAULT_HEADERS = [
        'Content-Type' => 'application/json',
        'Accept ' => 'application/json',
    ];

    private const DEFAULT_CURL_OPTIONS = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_AUTOREFERER => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false,
    ];

    protected function __construct(string $endpointRoot, array $config)
    {
        $this->endpointRoot = $endpointRoot;
        $this->apiConfig = $config;
        $this->url = $config['is_prod'] ? self::DOMAIN : self::DOMAIN . '/sandbox';
        $this->curl = curl_init();
        self::validateApiConfigParams();

        if (version_compare(phpversion(), '7.1', '>=')) {
            ini_set('precision', 17);
            ini_set('serialize_precision', -1);
        }
    }

    private function whichUserAgent()
    {
        return 'FiservPHPClient/' . self::VERSION . ' ' . self::USER;
    }

    /**
     * Create an header object that conforms to API specs. 
     * A message signature is created by wrapping a hash (SHA256) calculation with the secret key.
     * 
     * @param string $content Request body for POST/PUT requests. May be empty (but not null).
     * @return string Array representing the header
     */
    protected function buildHeadersWithMessage(string $content): array
    {
        $clientRequestId = self::generateUuid();
        $timestamp = self::generateTimestamp();
        $message = $this->apiConfig['api_key'] . $clientRequestId . $timestamp . strval($content);
        $requestHeaders = self::DEFAULT_HEADERS;
        $requestHeaders['Api-Key'] = $this->apiConfig['api_key'];
        $requestHeaders['Timestamp'] = $timestamp;
        $requestHeaders['Client-Request-Id'] = $clientRequestId;
        $requestHeaders['Message-Signature'] = self::calculcateMessageSignature($message);
        $headers = [];
        foreach ($requestHeaders as $key => $value) {
            $headers[] = $key . ': ' . $value;
        }
        return $headers;
    }

    private function calculcateMessageSignature(string $content): string
    {
        return base64_encode(hash_hmac('sha256', $content, $this->apiConfig['api_secret'], true));
    }

    private static function generateUuid(): string
    {
        $out = bin2hex(random_bytes(18));

        $out[8] = "-";
        $out[13] = "-";
        $out[18] = "-";
        $out[23] = "-";
        $out[14] = "4";
        $out[19] = ["8", "9", "a", "b"][random_int(0, 3)];
        return $out;
    }

    private static function generateTimestamp()
    {
        return intval(microtime(true) * 1000);
    }

    /**
     * Custom request service that uses cURL for API requests
     * 
     * @param RequestType $type GET, POST or PATCH
     * @param string $url Full URI with root and service path
     * @param string $req Request body for POST, PATCH requests as JSON string 
     */
    protected function curlRequest(RequestType $type, string $url, string $request = ''): array
    {
        $headers = [];

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_USERAGENT => self::whichUserAgent(),
            CURLOPT_HTTPHEADER => self::buildHeadersWithMessage($request),
            CURLOPT_HEADERFUNCTION => function ($curl, $header) use (&$headers) {
                if (str_contains($header, ':')) {
                    list($key, $value) = explode(':', $header, 2);
                    $headers[$key] = trim($value);
                }
                return strlen($header);
            }
        ];

        switch ($type) {
            case RequestType::POST:
            case RequestType::PATCH:
                $options[CURLOPT_POST] = 1;
                $options[CURLOPT_POSTFIELDS] = $request;
        }

        curl_setopt_array($this->curl, $options + self::DEFAULT_CURL_OPTIONS);

        $response = curl_exec($this->curl);

        if (curl_errno($this->curl)) {
            throw new CurlRequestException(curl_error(($this->curl)));
        }
        $httpCode = curl_getinfo($this->curl, CURLINFO_RESPONSE_CODE);
        switch ($httpCode) {
            case 200:
            case 201:
                return [
                    'data' => $response,
                    'trace-id' => $headers['trace-id']
                ];
            case 400:
                throw new BadRequestException($httpCode, $response['detail'], $headers['trace-id']);
            default:
                throw new ServerException($httpCode . ' : ' .  $response);
        }
    }

    /**
     * Check ApiConfig parameters and prevent requests on missing params.
     */
    protected function validateApiConfigParams(): void
    {
        if (is_null($this->apiConfig['api_key'])) {
            throw new Exception("No valid API key has been provided. Set it in ApiConfig class");
        }

        if (is_null($this->apiConfig['api_secret'])) {
            throw new Exception("No valid API Secret has been provided. Set it in ApiConfig class");
        }

        if (is_null($this->apiConfig['store_id'])) {
            throw new Exception("No valid API Secret has been provided. Set it in ApiConfig class");
        }
    }

    /**
     * Request builder that wraps curl requestor to validate and return DTO objects
     * 
     * @param RequestType $type GET, POST or PATCH
     * @param string $endpoint Path of URL to call without root
     * @param FiservObject $requestBody Optional request body which is null on GET requests
     * @param CurlHandle $client Optional handle object which should be passed to running requests to prevent reconnects
     * 
     */
    protected function buildRequest(RequestType $type, string $endpoint, FiservObject $requestBody = null, string $responseClass = null): mixed
    {
        if ($requestBody instanceof FiservObject) {
            self::validateRequest($requestBody);
            $requestBody->storeId = $this->apiConfig['store_id'];
        }

        if ($requestBody instanceof ValidationInterface) {
            $requestBody->validate();
        }

        try {
            $response = self::curlRequest($type, $this->url . $endpoint, json_encode($requestBody));
        } catch (CurlRequestException $e) {
            throw $e;
        }

        $responseObject = new $responseClass($response['data']);
        if ($responseObject instanceof ResponseInterface) {
            $responseObject->traceId = $response['trace-id'];
        }

        return $responseObject;
    }

    /**
     * Run validation checks before request and
     * throw on failure.
     * 
     * @param FiservObject $requestBody Request to be validated
     */
    private function validateRequest(FiservObject $requestBody): void
    {
        foreach ($requestBody as $key => $value) {
            if ($value instanceof FiservObject) {
                self::validateRequest($value);
            }

            if ($value instanceof ValidationInterface) {
                $value->validate();
            }
        }
    }
}
