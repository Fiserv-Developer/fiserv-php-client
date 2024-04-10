<?php
use Fiserv\HttpClient;

class PaymentSchedules
{
    const endpointRoot = '/ipp/payments-gateway/v2/payment-schedules';

    public static function createPaymentSchedule($client)
    {
        $requestBody = [];
        $endpoint = PaymentSchedules::endpointRoot;
        return HttpClient::buildRequest($client, 'POST', $endpoint, $requestBody);
    }

    public static function inquiryPaymentSchedule($client)
    {
        $endpoint = PaymentSchedules::endpointRoot;
        return HttpClient::buildRequest($client, 'GET', $endpoint, null);
    }

    public static function cancelPaymentSchedule($client)
    {
        $endpoint = PaymentSchedules::endpointRoot;
        return HttpClient::buildRequest($client, '\DELETE', $endpoint, null);
    }

    public static function updatePaymentSchedule($client)
    {
        $requestBody = [];
        $endpoint = PaymentSchedules::endpointRoot;
        return HttpClient::buildRequest($client, 'PATCH', $endpoint, $requestBody);
    }
}