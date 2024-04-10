<?php

namespace Fiserv\Payments;

use Fiserv\HttpClient;
use Fiserv\OrderModels\Order;
use Fiserv\OrderModels\StandInDetails;
use stdClass;

class Payment
{
    const endpointRoot = '/ipp/payments-gateway/v2/payments';

    public static function submitPrimaryTransaction($client)
    {
        $requestBody = (object) [
            'standInDetails' => [
                'standInType' => 'FIXED_AMOUNT',
                'siValidated' => true,
                'frequency' => 'DAILY',
            ],
            'additionalDetails' => [
                'receipts' => [
                    'type' => 'cardholder',
                ],
            ],
            'bancontactQR' => [
                'transactionRoutingMeans' => 'QR Code',
            ],
            'recurringPaymentDetails' => [
                'additionalDetails' => [
                    'receipts' => [
                        'type' => 'cardholder',
                    ],
                ],
                'frequency' => 'DAILY',
                'additionalRecurringData' => [
                    'validationIndicator' => false,
                ]
            ],
            'paymentMethod' => [
                'paymentFacilitator' => [
                    'subMerchantData' => [
                        'document' => [
                            'type' => 'NATIONAL_IDENTITY',
                        ],
                    ]
                ]
            ]
        ];


        $endpoint = Payment::endpointRoot;
        return HttpClient::buildRequest($client, 'POST', $endpoint, $requestBody);
    }

    public static function transactionInquiry($client, $transactionId)
    {
        $endpoint = Payment::endpointRoot . $transactionId;
        return HttpClient::buildRequest($client, 'GET', $endpoint, null);
    }

    public static function finalizeSecureTransaction($client, $transactionId)
    {
        $requestBody = [];
        $endpoint = Payment::endpointRoot . $transactionId;
        return HttpClient::buildRequest($client, 'PATCH', $endpoint, $requestBody);
    }

    public static function submitSecondaryTransaction($client, $transactionId)
    {
        $requestBody = [];
        $endpont = Payment::endpointRoot . $transactionId;
        return HttpClient::buildRequest($client, 'POST', $endpont, $requestBody);
    }

    public static function submitUpdateTransaction($client, $transactionId)
    {
        $requestBody = [];
        $endpoint = Payment::endpointRoot . $transactionId;
        return HttpClient::buildRequest($client, 'PATCH', $endpoint, $requestBody);
    }
}