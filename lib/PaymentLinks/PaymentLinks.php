<?php

namespace Fiserv\PaymentLinks;

use Fiserv\HttpClient;
use Fiserv\SdkReponse;
use PaymentLinkData;
use PaymentsLinksCreatedResponse;

class PaymentLinks
{
    const endpointRoot = '/exp/v1/payment-links';

    public static function createPaymentLink($client, PaymentLinkData $req): SdkReponse
    {
        $endpoint = self::endpointRoot;
        $res = HttpClient::buildRequest($client, 'POST', $endpoint, $req);
        $res->data = new PaymentsLinksCreatedResponse(json_encode($res->data));
        return $res;
    }

    public static function getPaymentLinkDetails($client, $checkoutId)
    {
        $endpoint = '/exp/v1/checkouts/' . $checkoutId;
        return HttpClient::buildRequest($client, 'GET', $endpoint);
    }
}