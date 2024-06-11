<?php

use Fiserv\CheckoutSolution;
use Fiserv\Fixtures;
use PHPUnit\Framework\TestCase;

class CheckoutModularTest extends TestCase
{

    protected function setUp(): void
    {
        Config::$ORIGIN = 'PHP Unit';
        Config::$API_KEY = '7V26q9EbRO2hCmpWARdFtOyrJ0A4cHEP';
        Config::$API_SECRET = 'KCFGSj3JHY8CLOLzszFGHmlYQ1qI9OSqNEOUj24xTa0';
        Config::$STORE_ID = '72305408';
    }

    public const RequestBody = [
        'transactionOrigin' => 'ECOM',
        'transactionType' => 'SALE',
        'transactionAmount' => [
            'total' => 0,
            'currency' => 'EUR'
        ],
        'checkoutSettings' => [
            'locale' => 'en_GB',
            'webHooksUrl' => 'https://nonce.com',
            'redirectBackUrls' => [
                'successUrl' => 'https://nonce.com',
                'failureUrl' => 'https://nonce.com'
            ]
        ],
        'paymentMethodDetails' => [
            'cards' => [
                'createToken' => [
                    'toBeUsedFor' => 'UNSCHEDULED',
                ],
            ],
        ],
        'storeId' => 'NULL',
        'order' => [
            'orderDetails' => [
                'purchaseOrderNumber' => 0,
            ],
            'billing' => [
                'person' => [],
                'contact' => [],
                'address' => [],
            ]
        ]
    ];

    public function testFlooringTransactionAmount(): void
    {
        $req = new CreateCheckoutRequest(self::RequestBody);
        $req->transactionAmount->total = 20.8899;
        $this->assertEquals($req->transactionAmount->total, 20.8899);

        $res = CheckoutSolution::postCheckouts($req);
        $this->assertInstanceOf(PostCheckoutsResponse::class, $res, "Response schema is malformed");
    }

    public function testStringValueOfEnum(): void
    {
        $status = transactionStatus::APPROVED;
        $this->assertIsString($status);
        $this->assertEquals($status, 'APPROVED');
    }
}
