<?php

namespace Fiserv;

use CreateCheckoutRequest;
use PHPUnit\Framework\TestCase;


class Fixtures extends TestCase
{
    public const paymentlinkResponseContent = [
        "storeId" => "72305408",
        "checkoutId" => "IUBsFE",
        "orderId" => "72110c52-5f65-4206-8981-fa6406439aee",
        "transactionType" => "SALE",
        "approvedAmount" => [
            "total" => 25,
            "currency" => "EUR",
            "components" => [
                "subtotal" => 20,
                "vatAmount" => 2,
                "shipping" => 3
            ],
        ],
        "transactionStatus" => "INITIATED",
        "requestSent" => [
            "orderDetails" => [],
            "checkoutSettings" => [
                "redirectBackUrls" => [
                    "successUrl" => "https://www.success.com/",
                    "failureUrl" => "https://www.failureexample.com"
                ],
            ],
            "paymentMethodDetails" => [
                "cards" => [
                    "authenticationPreferences" => [
                        "challengeIndicator" => "01"
                    ],
                    "tokenBasedTransaction" => [
                        "value" => "ApoorvaTest9thNov",
                        "transactionSequence" => "SUBSEQUENT"
                    ],
                ],
                "sepaDirectDebit" => [
                    "transactionSequenceType" => "SINGLE"
                ],
                "payPal" => [
                    "riskData" => [],
                ],
            ],
        ],
    ];

    public const paymentLinksRequestContent = [
        'transactionOrigin' => 'ECOM',
        'transactionType' => 'SALE',
        'transactionAmount' => [
            'total' => 130,
            'currency' => 'EUR',
            'components' => [
                'subtotal' => 130,
                'vatAmount' => 0,
                'shipping' => 0,
            ]
        ],
        'checkoutSettings' => [
            'locale' => 'en_GB',
            'webHooksUrl' => 'https://www.success.com/',
            'redirectBackUrls' => [
                'successUrl' => "https://www.success.com/",
                'failureUrl' => "https://www.failureexample.com"
            ]
        ],
        'paymentMethodDetails' => [
            'cards' => [
                'authenticationPreferences' => [
                    'challengeIndicator' => '01',
                    'skipTra' => false,
                ],
                'createToken' => [
                    'declineDuplicateToken' => false,
                    'reusable' => true,
                    'toBeUsedFor' => 'UNSCHEDULED',
                ],
                'tokenBasedTransaction' => ['transactionSequence' => 'FIRST']
            ],
            'sepaDirectDebit' => ['transactionSequenceType' => 'SINGLE']
        ],
        'merchantTransactionId' => 'AB-1234',
        'storeId' => '72305408',
    ];

    public function testDeserializedDeeplyNestedField(): void
    {
        $data = new CreateCheckoutRequest(self::paymentLinksRequestContent);
        $this->assertEquals($data->paymentMethodDetails->cards->tokenBasedTransaction->transactionSequence, 'FIRST', 'Correct');
    }
}
