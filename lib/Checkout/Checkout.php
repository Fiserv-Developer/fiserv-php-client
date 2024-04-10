<?php

namespace Fiserv;

use Fiserv\HttpClient;
use GuzzleHttp\Client;
use PostCheckoutsRequest;
use PostCheckoutsResponse;

class Checkout
{
    const endpointRoot = '/exp/v1/checkouts';

    /**
     * $client - HTTP client
     * $request - Request body for checkout link creation
     */
    public static function postCheckouts(Client $client, PostCheckoutsRequest $req): SdkReponse
    {
        $endpoint = self::endpointRoot;
        $res = HttpClient::buildRequest($client, 'POST', $endpoint, $req);
        $res->data = new PostCheckoutsResponse(json_encode($res->data));
        return $res;
    }


    /**
     * $client - HTTP client
     * $checkoutId - String checkout ID to be queried  
     */
    public static function getCheckoutId(Client $client, string $checkoutId): SdkReponse
    {
        $endpoint = self::endpointRoot . $checkoutId;
        $res = HttpClient::buildRequest($client, 'GET', $endpoint);
        $res->data = new PostCheckoutsResponse();
        return $res;
    }
}