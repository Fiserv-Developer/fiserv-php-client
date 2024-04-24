<?php

namespace Fiserv;

use BadRequestException;
use Config;
use CurlHandle;
use CurlRequestException;
use Exception;
use Fiserv\models\FiservObject;
use Fiserv\Util\Util;
use RequestBodyException;
use ServerException;

class HttpClient
{
    private const domain = 'https://prod.emea.api.fiservapps.com/';
    private static $url = Config::IS_PROD ? self::domain : self::domain . '/sandbox';

    public static function buildHeadersWithMessage(string $content)
    {
        $clientRequestId = Util::uuid_create();
        $timestamp = strval(intval(microtime(true) * 1000));
        $message = Config::$API_KEY . $clientRequestId . $timestamp . strval($content);

        $signature = hash_hmac('sha256', $message, Config::$API_SECRET, true);
        $b64_sig = base64_encode($signature);

        // $headers = [
        //     'Api-Key' => self::$key,
        //     'Timestamp' => $timestamp,
        //     'Client-Request-Id' => $clientRequestId,
        //     'Message-Signature' => $b64_sig,
        //     'Content-Type' => 'application/json',
        //     'accept' => 'application/json',
        // ];

        $headers = [
            'Api-Key: ' . Config::$API_KEY,
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
    public static function curlRequest(RequestType $type, string $url, string $req = ""): array
    {
        $handle = curl_init();
        $headers = self::buildHeadersWithMessage($req);

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_AUTOREFERER => 1,
            CURLOPT_USERAGENT => Config::$ORIGIN,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_HEADER => 1,
            CURLOPT_HTTPHEADER => $headers,
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
        $traceId = $payload['trace-id'];

        return [
            'data' => $data,
            'code' => $code,
            'traceId' => $traceId,
        ];
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
     * Check Config parameters and prevent requests on missing params.
     */
    private static function validateConfigParams(): void
    {
        if (is_null(Config::$API_KEY)) {
            throw new Exception("No valid API key has been provided. Set it in Config class");
        }

        if (is_null(Config::$API_SECRET)) {
            throw new Exception("No valid API Secret has been provided. Set it in Config class");
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
        self::validateConfigParams();

        if ($type === RequestType::GET xor is_null($requestBody)) {
            throw new RequestBodyException($type);
        }

        try {
            $requestBodyJson = json_encode($requestBody);
            $response = self::curlRequest($type, self::$url . $endpoint, $requestBodyJson);
        } catch (CurlRequestException $e) {
            throw $e;
        }

        $data = json_decode($response['data']);
        $code = $response['code'];

        if ($code == 503) {
            throw new ServerException('Internal Error: No healthy upstream. Try again at a later time');
        }

        if ($code !== 201 && $code !== 200) {
            throw new BadRequestException($code, json_encode($data), $response['traceId']);
        }

        return json_decode(json_encode($data), true);
    }
}

enum RequestType
{
    case GET;
    case POST;
    case PATCH;
}
