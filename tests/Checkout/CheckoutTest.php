<?php

use Fiserv\Checkout;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class CheckoutTest extends TestCase
{
    private $client = null;

    private $mockResponseCreated = [
        "checkout" => [
            "storeId" => "72305408",
            "checkoutId" => "IUBsFE",
            "redirectionUrl" => "https://checkout-lane.com/?checkoutId=IUBsFE"
        ]
    ];

    protected function setUp(): void
    {
        $this->client = new Client();
    }

    public function testPostCheckoutsSuccess(): void
    {
        $request = new PostCheckoutsRequest(json_encode([
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
        ]));

        $response = Checkout::postCheckouts($this->client, $request);

        $this->assertEquals($response->statusCode, 201);
        $this->assertObjectHasProperty("paymentLink", $response->data, "Response misses field (paymentlink)");
        $this->assertInstanceOf(PostCheckoutsResponse::class, $response->data, "Response schema is malformed");
    }

    public function testPostMalformedBody(): void
    {
        $request = new PostCheckoutsRequest(json_encode([
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
        ]));
    }

    public function testGetCheckoutIdSuccess(): void
    {
        $mockCheckoutId = 'IUBsFE';
        // $response = Checkout::getCheckoutId($this->client, $mockCheckoutId);
        // $this->assertEquals($response->statusCode, 201);
        // $this->assertInstanceOf(GetCheckoutIdResponse::class, $response->data);
    }
}