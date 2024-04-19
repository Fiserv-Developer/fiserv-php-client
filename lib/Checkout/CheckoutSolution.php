<?php

namespace Fiserv;

use CheckoutCreatedResponse;
use Fiserv\HttpClient;
use GetCheckoutIdResponse;
use PaymentLinkRequestContent;

class CheckoutSolution
{
    const endpointRoot = '/exp/v1/checkouts';

    /**
     * $request - Request body for checkout link creation
     */
    public static function postCheckouts(PaymentLinkRequestContent $req): CheckoutCreatedResponse
    {
        $endpoint = self::endpointRoot;
        $res = HttpClient::buildRequest(RequestType::POST, $endpoint, $req);
        $data = new CheckoutCreatedResponse($res);

        return $data;
    }


    /**
     * $checkoutId - String checkout ID to be queried  
     */
    public static function getCheckoutId(string $checkoutId): GetCheckoutIdResponse
    {
        $endpoint = self::endpointRoot . "/" . $checkoutId;
        $res = HttpClient::buildRequest(RequestType::GET, $endpoint);
        $data = new GetCheckoutIdResponse($res);

        return $data;
    }
}