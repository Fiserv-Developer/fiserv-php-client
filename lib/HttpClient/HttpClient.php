<?php

namespace Fisrv\HttpClient;

use CurlHandle;
use Exception;
use Fisrv\Exception\BadRequestException;
use Fisrv\Exception\CurlRequestException;
use Fisrv\Exception\ResponseMalformedException;
use Fisrv\Exception\ServerException;
use Fisrv\Models\fisrvObject;
use Fisrv\Models\RequestInterface;
use Fisrv\Models\ResponseInterface;
use Fisrv\Models\ValidationInterface;

abstract class HttpClient
{
    private const VERSION = '0.1.4';
    private const DOMAIN = 'https://prod.emea.api.fiservapps.com/';
    protected string $endpointRoot;
    
    /** @var array<string, string | bool> */
    protected array $config;
    private string $url;
    private CurlHandle $session;

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

    /**
     * HttpClient constructor
     * 
     * @param array<string, string | bool> $config Config parameters
     */
    protected function __construct(string $endpointRoot, array $config)
    {
        $this->endpointRoot = $endpointRoot;

        foreach ($config as $key => $value) {
            $valid_keys = [
                'is_prod',
                'api_key',
                'api_secret',
                'store_id',
                'user',
            ];

            if (!in_array($key, $valid_keys)) {
                throw new Exception('Key ' . $key . ' in config is not valid. Valid keys are: ' . implode(' | ', $valid_keys));
            }

            $this->config[$key] = $value;
        }

        $this->url = $config['is_prod'] ? self::DOMAIN : self::DOMAIN . '/sandbox';
        $this->session = curl_init();
        self::validateApiConfigParams();

        if (version_compare(phpversion(), '7.1', '>=')) {
            ini_set('precision', 17);
            ini_set('serialize_precision', -1);
        }
    }

    private function whichUserAgent(): string
    {
        return 'fisrvPHPClient/' . self::VERSION . ' ' . ($this->config['user'] ?? '');
    }

    /**
     * Create an header object that conforms to API specs. 
     * A message signature is created by wrapping a hash (SHA256) calculation with the secret key.
     * 
     * @param string $content Request body for POST/PUT requests. May be empty (but not null).
     * @return array<string> Array representing the header
     */
    protected function authenticate(string $content): array
    {
        $clientRequestId = self::generateUuid();
        $timestamp = self::generateTimestamp();
        $message = $this->config['api_key'] . $clientRequestId . $timestamp . $content;
        $requestHeaders = self::DEFAULT_HEADERS;
        $requestHeaders['Api-Key'] = $this->config['api_key'];
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
        return base64_encode(hash_hmac('sha256', $content, strval($this->config['api_secret']), true));
    }

    /**
     * Generate UUIDv4 for message header authentication
     * 
     * @return string UUIDv4 string
     */
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

    /**
     * Generate timestamp for message header authentication
     * 
     * @return int UNIX timestamp in seconds
     */
    private static function generateTimestamp(): int
    {
        return intval(microtime(true) * 1000);
    }

    /**
     * Custom request service that uses cURL for API requests
     * 
     * @param RequestType $type GET, POST or PATCH
     * @param string $url Full URI with root and service path
     * @param string $request Request body for POST, PATCH requests as JSON string 
     * 
     * @return array<string, bool | string> Response object containing data and trace ID 
     */
    protected function curlRequest(RequestType $type, string $url, string $request = ''): array
    {
        $headers = [];

        $options = [
            CURLOPT_POST => false,
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => $type->value,
            CURLOPT_USERAGENT => self::whichUserAgent(),
            CURLOPT_HTTPHEADER => self::authenticate($request),
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
                $options[CURLOPT_POST] = true;
                $options[CURLOPT_POSTFIELDS] = $request;
        }

        curl_setopt_array($this->session, $options + self::DEFAULT_CURL_OPTIONS);
        $response = curl_exec($this->session);

        if (is_bool($response)) {
            throw new Exception('CURLOPT_RETURNTRANSFER is not set to true. Could not retrieve response data.' . $response);
        }

        if (curl_errno($this->session)) {
            throw new CurlRequestException(curl_error(($this->session)));
        }

        $httpCode = curl_getinfo($this->session, CURLINFO_RESPONSE_CODE);

        switch ($httpCode) {
            case 200:
            case 201:
                return [
                    'data' => $response,
                    'trace-id' => $headers['trace-id']
                ];
            case 400:
                throw new BadRequestException($httpCode, $response, $headers['trace-id'] ?? 'NO_TRACE_ID');
            default:
                throw new ServerException($httpCode . ' : ' .  $response);
        }
    }

    /**
     * Check ApiConfig parameters and prevent requests on missing params.
     */
    protected function validateApiConfigParams(): void
    {
        if (!isset($this->config['api_key'])) {
            throw new Exception("No valid API key has been provided. Set it in ApiConfig class");
        }

        if (!isset($this->config['api_secret'])) {
            throw new Exception("No valid API Secret has been provided. Set it in ApiConfig class");
        }

        if (!isset($this->config['store_id'])) {
            throw new Exception("No valid API Secret has been provided. Set it in ApiConfig class");
        }
    }

    /**
     * Request builder that wraps curl requestor to validate and return DTO objects
     * 
     * @param RequestType $type GET, POST or PATCH
     * @param string $endpoint Path of URL to call without root
     * @param fisrvObject $requestBody Optional request body which is null on GET requests
     * @param string $responseClass Response class type of ResponseInterface
     * 
     * @return ResponseInterface Response object
     */
    protected function buildRequest(RequestType $type, string $endpoint, fisrvObject $requestBody = null, string $responseClass = null): ResponseInterface
    {
        if ($requestBody instanceof RequestInterface) {
            $this->validateRequest($requestBody);
            $requestBody->storeId = strval($this->config['store_id']);
        }

        try {
            $curlPayload = json_encode($requestBody);

            if (!is_string($curlPayload)) {
                $curlPayload = '';
            }

            $response = $this->curlRequest($type, $this->url . $endpoint, $curlPayload);
        } catch (CurlRequestException $e) {
            throw $e;
        }

        $responseObject = new $responseClass($response['data']);

        if (!$responseObject instanceof ResponseInterface) {
            throw new ResponseMalformedException();
        }
        
        $responseObject->traceId = strval($response['trace-id']);
        return $responseObject;
    }

    /**
     * Run validation checks before request and
     * throw on failure.
     * 
     * @param fisrvObject $requestBody Request to be validated
     */
    private function validateRequest(fisrvObject $requestBody): void
    {
        foreach (get_object_vars($requestBody) as $value) {
            if ($value instanceof fisrvObject) {
                self::validateRequest($value);
            }

            if ($value instanceof ValidationInterface) {
                $value->validate();
            }
        }
    }
}
