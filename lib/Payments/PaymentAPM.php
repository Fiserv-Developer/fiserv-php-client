<?php
use Fiserv\HttpClient;

class PaymentAPM
{
    const endpointRoot = '/ipp/payments-gateway/v2/payments/apm/';

    public static function submitApmAction($client, $transactionId)
    {
        $endpoint = PaymentAPM::endpointRoot . $transactionId;
        return HttpClient::buildRequest($client, 'GET', $endpoint, null);
    }

    public static function submitApmUpdateTransaction($client, $transactionId)
    {
        $endpoint = PaymentAPM::endpointRoot . $transactionId;
        return HttpClient::buildRequest($client, 'PATCH', $endpoint, null);
    }
}