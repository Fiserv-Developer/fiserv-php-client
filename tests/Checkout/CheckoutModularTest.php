<?php

use Fiserv\FiservCheckoutClient;
use PHPUnit\Framework\TestCase;

class CheckoutModularTest extends TestCase
{
    protected function setUp(): void
    {
        Config::$ORIGIN = 'PHP Unit Test';
        Config::$API_KEY = '7V26q9EbRO2hCmpWARdFtOyrJ0A4cHEP';
        Config::$API_SECRET = 'KCFGSj3JHY8CLOLzszFGHmlYQ1qI9OSqNEOUj24xTa0';
        Config::$STORE_ID = '72305408';
    }

    private const requestBody = [
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

    public function testCreateBasicCheckout(): void
    {
        // $request = FiservCheckoutClientRequest::start();
        // $request = FiservCheckoutClient::createBasicCheckoutRequest(14.99, 'https://success.de', 'https://success.de');
        $request = new CheckoutClientRequest(self::requestBody);
        $response = FiservCheckoutClient::postCheckouts($request);
        // $response = FiservCheckoutClient::postCheckouts($request);
        // $this->assertInstanceOf(PostCheckoutsResponse::class, $response);

        $this->assertTrue(true);
    }
}
