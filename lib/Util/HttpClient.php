<?php

namespace Fiserv;

use Fiserv\models\FiservObject;
use Fiserv\Util\Util;
use GuzzleHttp\Client;
use RequestBodyException;

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

    public static function buildRequest(Client $client, RequestType $type, string $endpoint, FiservObject $requestBody = null): SdkReponse
    {
        if ($type === RequestType::GET xor is_null($requestBody)) {
            throw new RequestBodyException($type);
        }

        $requestBodyJson = "NOT SET";

        $requestBodyJson = json_encode($requestBody);
        $payload = ['headers' => self::buildHeadersWithMessage($requestBodyJson)];

        if ($type === RequestType::POST) {
            $payload['body'] = $requestBodyJson;
        }

        try {
            $response = $client->request($type->name, self::$url . $endpoint, $payload);
        } catch (\GuzzleHttp\Exception\RequestException $ex) {
            throw $ex;
        }
        $data = json_decode($response->getBody());
        return new SdkReponse(
            json_decode(json_encode($data), true),
            $response->getStatusCode()
        );
    }
}

enum RequestType
{
    case GET;
    case POST;
    case PATCH;
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