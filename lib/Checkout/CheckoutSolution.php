<?php

namespace Fiserv;

use PostCheckoutsResponse;
use Fiserv\HttpClient;
use GetCheckoutIdResponse;
use PaymentLinkRequestBody;

class CheckoutSolution
{
    const endpointRoot = '/exp/v1/checkouts';

    /**
     * Create a checkout link to be used as checkout solution.
     * Pass an optional webhook to receive status events from fiserv server.
     * 
     * @var PaymentLinkRequestBody $req - Request body containing checkout options
     */
    public static function postCheckouts(PaymentLinkRequestBody $req): PostCheckoutsResponse
    {
        $endpoint = self::endpointRoot;
        $res = HttpClient::buildRequest(RequestType::POST, $endpoint, $req);
        $data = new PostCheckoutsResponse($res);

        return $data;
    }


    /**
     * Query an existing checkout link object by given ID. 
     * Responds with verbose list about checkout configuration.
     * 
     * @var string $checkoutId - String checkout ID to be queried  
     */
    public static function getCheckoutId(string $checkoutId): GetCheckoutIdResponse
    {
        $endpoint = self::endpointRoot . "/" . $checkoutId;
        $res = HttpClient::buildRequest(RequestType::GET, $endpoint);
        $data = new GetCheckoutIdResponse($res);

        return $data;
    }
}
