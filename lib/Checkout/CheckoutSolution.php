<?php

namespace Fiserv;

use CheckoutCreatedResponse;
use Fiserv\HttpClient;
use GetCheckoutIdResponse;
use GuzzleHttp\Client;
use PaymentLinkRequestContent;

class CheckoutSolution
{
    const endpointRoot = '/exp/v1/checkouts';

    /**
     * $client - HTTP client
     * $request - Request body for checkout link creation
     */
    public static function postCheckouts(Client $client, PaymentLinkRequestContent $req): CheckoutCreatedResponse
    {
        $endpoint = self::endpointRoot;
        $res = HttpClient::buildRequest($client, RequestType::POST, $endpoint, $req);
        $data = new CheckoutCreatedResponse($res->data);

        return $data;
    }


    /**
     * $client - HTTP client
     * $checkoutId - String checkout ID to be queried  
     */
    public static function getCheckoutId(Client $client, string $checkoutId): GetCheckoutIdResponse
    {
        $endpoint = self::endpointRoot . "/" . $checkoutId;
        $res = HttpClient::buildRequest($client, RequestType::GET, $endpoint);
        $data = new GetCheckoutIdResponse($res->data);
        $res->data = $data;

        return $data;
    }
}