<?php
namespace Fiserv;

use PaymentLinksRequest;
use PHPUnit\Framework\TestCase;


class Fixtures extends TestCase
{
    public const paymentLinksRequestContent = [
        'transactionOrigin' => 'ECOM',
        'transactionType' => 'SALE',
        'transactionAmount' => ['total' => 130, 'currency' => 'EUR'],
        'checkoutSettings' => ['locale' => 'en_GB'],
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
        $data = new PaymentLinksRequest(self::paymentLinksRequestContent);
        $this->assertEquals($data->paymentMethodDetails->cards->tokenBasedTransaction->transactionSequence, 'FIRST', 'Correct');
    }
}