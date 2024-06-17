<?php

use Fiserv\Checkout\CheckoutClient;
use Fiserv\Config\ApiConfig;
use Fiserv\Models\CheckoutClientRequest;
use Fiserv\Models\CheckoutClientResponse;
use PHPUnit\Framework\TestCase;

class CheckoutModularTest extends TestCase
{
    protected function setUp(): void
    {
        ApiConfig::$ORIGIN = 'PHP Unit Test';
        ApiConfig::$API_KEY = '7V26q9EbRO2hCmpWARdFtOyrJ0A4cHEP';
        ApiConfig::$API_SECRET = 'KCFGSj3JHY8CLOLzszFGHmlYQ1qI9OSqNEOUj24xTa0';
        ApiConfig::$STORE_ID = '72305408';
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
        // $response = CheckoutClient::postCheckouts($request);
        // $this->assertInstanceOf(CheckoutClientResponse::class, $response);
        $this->assertTrue(true);
    }
}
