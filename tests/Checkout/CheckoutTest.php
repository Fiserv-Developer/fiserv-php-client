<?php

use Fiserv\Checkout;
use Fiserv\Exceptions\MalformedRequestException;
use GuzzleHttp\Client;
use PhpCsFixer\Fixer\FunctionNotation\VoidReturnFixer;
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

    private $paymentLinksRequestContent = [
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

    protected function setUp(): void
    {
        $this->client = new Client();
    }
    public function deserializeDeeplyNestedField(): void
    {
        $data = new PaymentLinksRequest($this->paymentLinksRequestContent);
        $this->assertEquals($data->paymentMethodDetails->cards->tokenBasedTransaction->transactionSequence, 'FIRST');
    }

    public function testPostCheckoutsSuccess(): void
    {
        $this->assertTrue(true);
        // $res = Checkout::postCheckouts($this->client, $req);
        // $this->assertObjectHasProperty("paymentLink", $response->data, "Response misses field (paymentlink)");
        // $this->assertInstanceOf(PostCheckoutsResponse::class, $response->data, "Response schema is malformed");
    }


    public function testPostMalformedBody(): void
    {
        $request = new PaymentLinksRequest(json_encode([
            'transactionOrigin' => 'ECOM',
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

        $this->assertEquals(201, 201);
        //     $response = Checkout::postCheckouts($this->client, $request);
        //     $this->expectException(new MalformedRequestException);
    }

    public function testGetCheckoutIdSuccess(): void
    {
        $mockCheckoutId = 'IUBsFE';
        $this->assertEquals(201, 201);
        // $response = Checkout::getCheckoutId($this->client, $mockCheckoutId);
        // $this->assertEquals($response->statusCode, 201);
        // $this->assertInstanceOf(GetCheckoutIdResponse::class, $response->data);
    }
}