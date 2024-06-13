<?php

namespace Fiserv\HttpClient;

use CurlHandle;
use Exception;
use Fiserv\Config\ApiConfig;
use Fiserv\Exception\BadRequestException;
use Fiserv\Exception\CurlRequestException;
use Fiserv\Exception\RequestBodyException;
use Fiserv\Exception\ServerException;
use Fiserv\Models\FiservObject;
use Fiserv\Util\Util;

class HttpClient
{
    private const domain = 'https://prod.emea.api.fiservapps.com/';
    private static $url = ApiConfig::IS_PROD ? self::domain : self::domain . '/sandbox';

    public function __construct()
    {
        if (version_compare(phpversion(), '7.1', '>=')) {
            ini_set('precision', 17);
            ini_set('serialize_precision', -1);
        }
    }

    /**
     * Create an header object that conforms to API specs. 
     * A message signature is created by wrapping a hash (SHA256) calculation with the secret key.
     * 
     * @param string $content Request body for POST/PUT requests. May be empty (but not null).
     * @return string Array representing the header
     */
    public static function buildHeadersWithMessage(string $content): array
    {
        $clientRequestId = Util::uuid_create();
        $timestamp = strval(intval(microtime(true) * 1000));
        $message = ApiConfig::$API_KEY . $clientRequestId . $timestamp . strval($content);

        $signature = hash_hmac('sha256', $message, ApiConfig::$API_SECRET, true);
        $b64_sig = base64_encode($signature);

        $headers = [
            'Api-Key: ' . ApiConfig::$API_KEY,
            'Timestamp: ' . $timestamp,
            'Client-Request-Id: ' . $clientRequestId,
            'Message-Signature: ' . $b64_sig,
            'Content-Type: ' . 'application/json',
            'accept: ' . 'application/json',
        ];

        return $headers;
    }

    /**
     * Custom request service that uses cURL for API requests
     * 
     * @param RequestType $type GET, POST or PATCH
     * @param string $url Full URI with root and service path
     * @param string $req Request body for POST, PATCH requests as JSON string 
     */
    private static function curlRequest(RequestType $type, string $url, string $req = '', bool $isFiservApi = true): array
    {
        $handle = curl_init();
        $headers = $isFiservApi ? self::buildHeadersWithMessage($req) : ['Content-Type: application/json'];

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_AUTOREFERER => true,
            CURLOPT_USERAGENT => ApiConfig::$ORIGIN,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_HEADER => true,
            CURLOPT_HTTPHEADER => $headers,
            /** SSL Options */
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
        ];


        if ($type === RequestType::POST && !is_null($req)) {
            $options[CURLOPT_POST] = 1;
            $options[CURLOPT_POSTFIELDS] = $req;
        }

        curl_setopt_array($handle, $options);
        $rawDataWithHeaders = curl_exec($handle);

        if (curl_errno($handle)) {
            $error = curl_error($handle);
            throw new CurlRequestException($error);
        }

        $payload = self::parseRawHeader($rawDataWithHeaders);
        $data = $payload['data'];

        $code = curl_getinfo($handle, CURLINFO_RESPONSE_CODE);

        if ($isFiservApi) {
            $traceId = $payload['trace-id'];
        }

        return [
            'data' => $data,
            'code' => $code,
            'traceId' => $traceId ?? 'null',
        ];
    }

    /**
     * Wrapper for external HTTP requests (non-API calls)
     * 
     * @param RequestType $type GET, POST or PATCH
     * @param string $url Full URI with root and service path
     * @param string $req Request body for POST, PATCH requests as JSON string 
     */
    public static function externalCurlRequest(RequestType $type, string $url, string $req = '')
    {
        return self::curlRequest($type, $url, $req, false);
    }

    /**
     * Parse raw data string returned by curl to readable PHP object.
     * Map key and value as specified on header.
     * 
     * @var string $rawDataWithHeaders - String response data from request
     */
    private static function parseRawHeader(string $rawDataWithHeaders): array
    {
        $lines = explode("\n", $rawDataWithHeaders);

        $parse = [];

        foreach ($lines as $line) {
            $fields = explode(": ", $line);

            if (count($fields) !== 2) {
                continue;
            }

            $key = $fields[0];
            $value = $fields[1];
            $parse[$key] = $value;
        }

        $parse['data'] = $lines[count($lines) - 1];

        return $parse;
    }

    /**
     * Check ApiConfig parameters and prevent requests on missing params.
     */
    private static function validateApiConfigParams(): void
    {
        if (is_null(ApiConfig::$API_KEY)) {
            throw new Exception("No valid API key has been provided. Set it in ApiConfig class");
        }

        if (is_null(ApiConfig::$API_SECRET)) {
            throw new Exception("No valid API Secret has been provided. Set it in ApiConfig class");
        }

        if (ApiConfig::$IS_SET) {
            throw new Exception("ApiConfig has not been set. Please create a ApiConfig object.");
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
     * @return array Associative array that should be parsed to its according DTO 
     */
    public static function buildRequest(RequestType $type, string $endpoint, FiservObject $requestBody = null, CurlHandle $client = null): array
    {
        self::validateApiConfigParams();

        if ($type === RequestType::GET xor is_null($requestBody)) {
            throw new RequestBodyException($type);
        }

        if ($requestBody instanceof FiservObject) {
            self::validateRequest($requestBody);
        }

        try {
            if (version_compare(phpversion(), '7.1', '>=')) {
                ini_set('precision', 17);
                ini_set('serialize_precision', -1);
            }

            $requestBodyJson = json_encode($requestBody);
            $response = self::curlRequest($type, self::$url . $endpoint, $requestBodyJson);
        } catch (CurlRequestException $e) {
            throw $e;
        }

        $data = json_decode($response['data']);
        $code = $response['code'];
        $traceId = $response['traceId'];
        $encoded = json_encode($data);

        self::handleStatusCodes($code, $encoded, $response);

        return
            [
                'data' => json_decode($encoded, true),
                'traceId' => $traceId,
            ];
    }

    /**
     * Run validation checks before request and
     * throw on failure.
     * 
     * @param FiservObject $requestBody Request to be validated
     */
    private static function validateRequest(FiservObject $requestBody): void
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

    /**
     * Block handling response error code by throwing
     * 
     * @param $code Reponse code
     * @param $encoded Encoded response data
     * @param $response Raw repsonse array
     */
    private static function handleStatusCodes($code, $encoded, $response)
    {
        if ($code == 503) {
            throw new ServerException('Internal Error: No healthy upstream. Try again at a later time');
        }

        if ($code !== 201 && $code !== 200) {
            $exceptionMessage = $encoded;

            if ($exceptionMessage === 'null') {
                $exceptionMessage = $response['data'];
            }

            throw new BadRequestException($code, $exceptionMessage, $response['traceId']);
        }
    }
}
