<?php

namespace Fiserv\PaymentLinks;

use Fiserv\HttpClient\HttpClient;
use Fiserv\HttpClient\RequestType;
use Fiserv\Models\CheckoutClientRequest;
use Fiserv\Models\GetPaymentLinkDetailsResponse;
use Fiserv\Models\PaymentsLinksCreatedResponse;

class PaymentLinksClient
{
    const endpointRoot = '/exp/v1/payment-links';

    public static function createPaymentLink(CheckoutClientRequest $req): PaymentsLinksCreatedResponse
    {
        $endpoint = self::endpointRoot;
        $res = HttpClient::buildRequest(RequestType::POST, $endpoint, $req);
        $data = new PaymentsLinksCreatedResponse($res['data']);

        return $data;
    }

    public static function getPaymentLinkDetails($paymentLinkId): GetPaymentLinkDetailsResponse
    {
        $endpoint = self::endpointRoot . "/" . $paymentLinkId;
        $res = HttpClient::buildRequest(RequestType::GET, $endpoint);
        $data = new GetPaymentLinkDetailsResponse($res['data']);

        return $data;
    }
}
