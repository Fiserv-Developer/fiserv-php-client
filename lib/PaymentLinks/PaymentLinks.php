<?php

namespace Fiserv\PaymentLinks;

use Fiserv\HttpClient;
use Fiserv\SdkReponse;

class PaymentLinks
{
    const endpointRoot = '/ipp/payments-gateway/v2/payments';

    public static function createPaymentLink($client, $paymentLinkId): SdkReponse
    {
        $endpoint = '/exp/v1/payment-links/' . $paymentLinkId;
        $res = HttpClient::buildRequest($client, 'GET', $endpoint, []);
        $res->data = new \PaymentsLinksCreatedResponse(json_encode($res->data));
        return $res;
    }

    public static function getPaymentLinkDetails($client, $checkoutId)
    {
        $endpoint = '/exp/v1/checkouts/' . $checkoutId;
        return HttpClient::buildRequest($client, 'GET', $endpoint, []);
    }
}