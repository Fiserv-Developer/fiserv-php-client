<?php

namespace Fisrv\Checkout;

use Fisrv\Environment;
use Fisrv\Exception\RequiredFieldMissingException;
use Fisrv\Models\CheckoutClientRequest;
use Fisrv\Models\CreateCheckoutResponse;
use Fisrv\Models\CreateToken;
use Fisrv\Models\GetCheckoutIdResponse;
use Fisrv\Models\LineItem;
use PHPUnit\Framework\TestCase;

class CheckoutTest extends TestCase
{
    private const paymentLinksRequestContent = [
        'transactionOrigin' => 'ECOM',
        'transactionType' => 'SALE',
        'transactionAmount' => [
            'total' => 130,
            'currency' => 'EUR',

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

    private CheckoutClient $client;

    protected function setUp(): void
    {
        $this->client = new CheckoutClient(Environment::getClientConfig());
    }

    public function testMissingFieldException(): void
    {
        $this->expectExceptionObject(new RequiredFieldMissingException("transactionType", CheckoutClientRequest::class));

        $missingFieldContent = self::paymentLinksRequestContent;
        unset($missingFieldContent["transactionType"]);

        new CheckoutClientRequest($missingFieldContent);
    }

    public function testNestedMissingFieldException(): void
    {
        $this->expectExceptionObject(new RequiredFieldMissingException("toBeUsedFor", CreateToken::class));

        $missingFieldContent = self::paymentLinksRequestContent;
        unset($missingFieldContent["paymentMethodDetails"]["cards"]["createToken"]["toBeUsedFor"]);

        $temp = new CheckoutClientRequest($missingFieldContent);
        echo $temp;
    }

    public function testPostCheckoutsSuccess(): void
    {
        $req = new CheckoutClientRequest(self::paymentLinksRequestContent);

        $res = $this->client->createCheckout($req);
        echo $res;
        $this->assertInstanceOf(CreateCheckoutResponse::class, $res, "Response schema is malformed");
        $this->assertObjectHasProperty("checkout", $res, "Response misses field (checkout)");
    }

    public function testOrderWithSubcomponents(): void
    {
        $total = 130;

        $req = new CheckoutClientRequest(self::paymentLinksRequestContent);
        $req->transactionAmount->total = $total;
        $req->transactionAmount->components->subtotal = $total - 0.99;
        $req->transactionAmount->components->vatAmount = 0;
        $req->transactionAmount->components->shipping = 0.99;

        $res = $this->client->createCheckout($req);
        $id = $res->checkout->checkoutId;

        $details = $this->client->getCheckoutById($id);
        $total_actual = $details->approvedAmount->total;

        $this->assertEquals($total, $total_actual);
    }

    public function testGetCheckoutIdSuccess(): void
    {
        $res = $this->client->getCheckoutById('IUBsFE');
        $this->assertInstanceOf(GetCheckoutIdResponse::class, $res);
        $this->assertObjectHasProperty("storeId", $res, "Response misses field (storeId)");
    }

    public function testCheckoutWithBasket(): void
    {
        $orderAddage = [
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

        $request = new CheckoutClientRequest(array_merge(self::paymentLinksRequestContent, $orderAddage));
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
