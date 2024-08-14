<?php

use Fisrv\Checkout\CheckoutClient;
use Fisrv\Models\CheckoutClientRequest;
use Fisrv\Models\CreateCheckoutResponse;
use Fisrv\Models\LineItem;
use Fisrv\Models\PaymentsClientRequest;
use Fisrv\Models\PaymentsClientResponse;
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
            ],
            'basket' => []
        ]
    ];

    public function testCreateBasicCheckout(): void
    {
        $request = new CheckoutClientRequest(self::requestBody);
        $response = $this->client->createCheckout($request);

        $this->assertInstanceOf(CreateCheckoutResponse::class, $response);
    }

    public function testCheckoutWithBasket(): void
    {
        $request = new CheckoutClientRequest(self::requestBody);
        $request->order->basket->lineItems[] = new LineItem([
            'name' => 'Thing',
            'quantity' => 3,
            'price' => 24.99,
        ]);

        $request->order->basket->lineItems[] = new LineItem([
            'name' => 'Another',
            'quantity' => 1,
            'price' => 8.99,
            'total' => 8.99,
        ]);

        $response = $this->client->createCheckout($request);

        $this->assertInstanceOf(CreateCheckoutResponse::class, $response);
    }

    // public function testRefundCheckout(): void
    // {
    //     $response = $this->client->refundCheckout(new PaymentsClientRequest([
    //         'transactionAmount' => [
    //             'total' => 1,
    //             'currency' => 'USD'
    //         ],
    //     ]), 'EDZjCI');

    //     $this->assertInstanceOf(PaymentsClientResponse::class, $response);
    // }
}
