<?php

use Fiserv\Checkout\CheckoutClient;
use Fiserv\Models\CheckoutClientRequest;
use Fiserv\Models\CheckoutClientResponse;
use PHPUnit\Framework\TestCase;

class CheckoutModularTest extends TestCase
{
    private CheckoutClient $client;

    protected function setUp(): void
    {
        $this->client = new CheckoutClient([
            'is_prod' => false,
            'api_key' => '7V26q9EbRO2hCmpWARdFtOyrJ0A4cHEP',
            'api_secret' => 'KCFGSj3JHY8CLOLzszFGHmlYQ1qI9OSqNEOUj24xTa0',
            'store_id' => '72305408',
        ]);
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
        $request = new CheckoutClientRequest(self::requestBody);
        $response = $this->client->createCheckout($request);
        $this->assertInstanceOf(CheckoutClientResponse::class, $response);
    }
}
