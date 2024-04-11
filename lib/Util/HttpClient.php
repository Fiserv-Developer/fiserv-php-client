<?php

namespace Fiserv;

use Fiserv\models\FiservObject;
use Fiserv\Util\Util;
use GuzzleHttp\Client;

class HttpClient
{
    private static $key = '7V26q9EbRO2hCmpWARdFtOyrJ0A4cHEP';
    public static $secret = 'KCFGSj3JHY8CLOLzszFGHmlYQ1qI9OSqNEOUj24xTa0';
    private static $url = 'https://prod.emea.api.fiservapps.com/sandbox';

    public static function buildHeadersWithMessage(string $content)
    {
        $clientRequestId = Util::uuid_create();
        $timestamp = strval(intval(microtime(true) * 1000));
        $message = self::$key . $clientRequestId . $timestamp . strval($content);

        $signature = hash_hmac('sha256', $message, self::$secret, true);
        $b64_sig = base64_encode($signature);

        $headers = [
            'Api-Key' => self::$key,
            'Timestamp' => $timestamp,
            'Client-Request-Id' => $clientRequestId,
            'Message-Signature' => $b64_sig,
            'Content-Type' => 'application/json',
            'accept' => 'application/json',
        ];

        return $headers;
    }

    public static function buildRequest(Client $client, string $type, string $endpoint, FiservObject $requestBody): SdkReponse
    {
        try {
            $requestBodyJson = "NOT SET";

            if (is_null($requestBody)) {
            }
            $requestBodyJson = json_encode($requestBody);

            $response = $client->request($type, self::$url . $endpoint, [
                'body' => $requestBodyJson,
                'headers' => self::buildHeadersWithMessage($requestBodyJson),
            ]);
        } catch (\GuzzleHttp\Exception\RequestException $ex) {
            throw $ex;
        }
        $data = json_decode($response->getBody());
        return new SdkReponse(
            $data,
            $response->getStatusCode()
        );
    }
}

class SdkReponse
{
    public $data;
    public string $statusCode;

    public function __construct($data, string $statusCode)
    {
        $this->data = $data;
        $this->statusCode = $statusCode;
    }
}