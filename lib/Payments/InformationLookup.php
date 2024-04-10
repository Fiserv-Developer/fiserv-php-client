<?php

namespace Fiserv\Payments;

use Fiserv\HttpClient;

class InformationLookup
{
    public static function cardInfoLookup($client, $requestBody)
    {
        $endpoint = '/ipp/payments-gateway/v2/card-information';
        return HttpClient::buildRequest($client, 'POST', $endpoint, $requestBody);
    }

    public static function lookUpAccount($client, $cardNumber)
    {
        $requestBody = new \PaymentToken('1235325235236', '12345500001', 'CREDIT', '977', new \ExpiryDate('02', '28'));
        $endpoint = '/ipp/payments-gateway/v2/account-information';
        return HttpClient::buildRequest($client, 'POST', $endpoint, $requestBody);
    }
}