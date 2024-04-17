<?php

namespace Fiserv\PaymentLinks;

use Fiserv\HttpClient;
use Fiserv\RequestType;
use Fiserv\SdkReponse;
use GetCheckoutIdResponse;
use GetPaymentLinkDetailsResponseContent;
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

    public static function getPaymentLinkDetails($client, $paymentLinkId): GetPaymentLinkDetailsResponseContent
    {
        $endpoint = self::endpointRoot . "/" . $paymentLinkId;
        $res = HttpClient::buildRequest($client, RequestType::GET, $endpoint);
        $data = new GetPaymentLinkDetailsResponseContent($res->data);
        $res->data = $data;

        return $data;
    }
}