<?php

namespace Fiserv;

use CurlHandle;
use CurlRequestException;
use Fiserv\models\FiservObject;
use Fiserv\Util\Util;
use RequestBodyException;

class HttpClient
{
    private static $key = '7V26q9EbRO2hCmpWARdFtOyrJ0A4cHEP';
    private static $secret = 'KCFGSj3JHY8CLOLzszFGHmlYQ1qI9OSqNEOUj24xTa0';
    private static $url = 'https://prod.emea.api.fiservapps.com/sandbox';

    public static function buildHeadersWithMessage(string $content)
    {
        $clientRequestId = Util::uuid_create();
        $timestamp = strval(intval(microtime(true) * 1000));
        $message = self::$key . $clientRequestId . $timestamp . strval($content);

        $signature = hash_hmac('sha256', $message, self::$secret, true);
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
            'Api-Key: ' . self::$key,
            'Timestamp: ' . $timestamp,
            'Client-Request-Id: ' . $clientRequestId,
            'Message-Signature: ' . $b64_sig,
            'Content-Type: ' . 'application/json',
            'accept: ' . 'application/json',
        ];

        return $headers;
    }

    public static function curlRequest(RequestType $type, string $url, string $data = "")
    {
        $handle = curl_init();
        $headers = self::buildHeadersWithMessage($data);

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_AUTOREFERER => 1,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)',
            CURLOPT_TIMEOUT => 10,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_0,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
        ];

        if ($type === RequestType::POST && !is_null($data)) {
            $options[CURLOPT_POST] = 1;
            $options[CURLOPT_POSTFIELDS] = $data;
        }

        curl_setopt_array($handle, $options);
        $data = curl_exec($handle);

        if (curl_errno($handle)) {
            $error = curl_error($handle);
            throw new CurlRequestException($error);
        }

        return $data;
    }

    /**
     * Original implementation to request builder that uses Guzzle library
     * 
     * @param RequestType $type GET, POST or PATCH
     * @param string $endpoint Path of URL to call without root
     * @param FiservObject $requestBody Optional request body which is null on GET requests
     * @param CurlHandle $client Optional handle object which should be passed to running requests to prevent reconnects
     */
    public static function buildRequest(RequestType $type, string $endpoint, FiservObject $requestBody = null, CurlHandle $client = null): SdkResponse
    {
        if ($type === RequestType::GET xor is_null($requestBody)) {
            throw new RequestBodyException($type);
        }

        try {
            $requestBodyJson = json_encode($requestBody);
        } catch (CurlRequestException $e) {
            throw $e;
        }

        $response = self::curlRequest($type, self::$url . $endpoint, $requestBodyJson);
        $data = json_decode($response);

        return new SdkResponse(
            json_decode(json_encode($data), true),
            200,
        );
    }
}

enum RequestType
{
    case GET;
    case POST;
    case PATCH;
}

class SdkResponse
{
    public $data;
    public string $statusCode;

    public function __construct($data, string $statusCode)
    {
        $this->data = $data;
        $this->statusCode = $statusCode;
    }
}