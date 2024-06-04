<?php

namespace Fiserv\PaymentLinks;

use Fiserv\HttpClient;
use Fiserv\RequestType;
use GetPaymentLinkDetailsResponse;
use CreateCheckoutRequest;
use PaymentsLinksCreatedResponse;

class PaymentLinks
{
    const endpointRoot = '/exp/v1/payment-links';

    public static function createPaymentLink(CreateCheckoutRequest $req): PaymentsLinksCreatedResponse
    {
        $endpoint = self::endpointRoot;
        $res = HttpClient::buildRequest(RequestType::POST, $endpoint, $req);
        $data = new PaymentsLinksCreatedResponse($res);

        return $data;
    }

    public static function getPaymentLinkDetails($paymentLinkId): GetPaymentLinkDetailsResponse
    {
        $endpoint = self::endpointRoot . "/" . $paymentLinkId;
        $res = HttpClient::buildRequest(RequestType::GET, $endpoint);
        $data = new GetPaymentLinkDetailsResponse($res);

        return $data;
    }
}
