<?php
use Fiserv\HttpClient;

class Order
{
    const endpointRoot = '/ipp/payments-gateway/v2/orders/';

    public static function submitSecondaryTransactionFromOrder($client, $orderId)
    {
        $requestBody = [];
        $endpoint = PaymentAPM::endpointRoot . $orderId;
        return HttpClient::buildRequest($client, 'POST', $endpoint, $requestBody);
    }

    public static function orderInquiry($client, $orderId)
    {
        $endpoint = PaymentAPM::endpointRoot . $orderId;
        return HttpClient::buildRequest($client, 'GET', $endpoint, null);
    }
}