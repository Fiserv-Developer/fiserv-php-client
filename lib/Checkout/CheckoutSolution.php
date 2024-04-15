<?php

namespace Fiserv;

use CheckoutCreatedResponse;
use Fiserv\HttpClient;
use GuzzleHttp\Client;
use PaymentLinkData;
use PaymentsLinksCreatedResponse;

class CheckoutSolution
{
    const endpointRoot = '/exp/v1/checkouts';

    /**
     * $client - HTTP client
     * $request - Request body for checkout link creation
     */
    public static function postCheckouts(Client $client, PaymentLinkData $req): SdkReponse
    {
        $endpoint = self::endpointRoot;
        $res = HttpClient::buildRequest($client, RequestType::POST, $endpoint, $req);

        $res->data = new CheckoutCreatedResponse($res->data);
        return $res;
    }


    /**
     * $client - HTTP client
     * $checkoutId - String checkout ID to be queried  
     */
    public static function getCheckoutId(Client $client, string $checkoutId): SdkReponse
    {
        $endpoint = self::endpointRoot . "/" . $checkoutId;
        $res = HttpClient::buildRequest($client, RequestType::GET, $endpoint);
        print_r($res->data);
        return $res;
    }
}