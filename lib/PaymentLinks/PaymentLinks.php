<?php

namespace Fiserv\PaymentLinks;

use Fiserv\HttpClient;
use Fiserv\RequestType;
use Fiserv\SdkResponse;
use GetCheckoutIdResponse;
use GetPaymentLinkDetailsResponse;
use PaymentLinkRequestContent;
use PaymentsLinksCreatedResponse;

class PaymentLinks
{
    const endpointRoot = '/exp/v1/payment-links';

    public static function createPaymentLink($client, PaymentLinkRequestContent $req): PaymentsLinksCreatedResponse
    {
        $endpoint = self::endpointRoot;
        $res = HttpClient::buildRequest($client, RequestType::POST, $endpoint, $req);
        $data = new PaymentsLinksCreatedResponse($res->data);

        return $data;
    }

    public static function getPaymentLinkDetails($client, $paymentLinkId): GetPaymentLinkDetailsResponse
    {
        $endpoint = self::endpointRoot . "/" . $paymentLinkId;
        $res = HttpClient::buildRequest($client, RequestType::GET, $endpoint);
        $data = new GetPaymentLinkDetailsResponse($res->data);
        $res->data = $data;

        return $data;
    }
}