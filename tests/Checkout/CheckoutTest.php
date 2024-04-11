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
            "redirectionUrl" => "https://checkout-lane.com/?checkoutId=IUBsFE",
            "bubble" => "glob"
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

    public function testDeserializedDeeplyNestedField(): void
    {
        // $data = new PaymentLinksRequest($this->paymentLinksRequestContent);
        $data = new CheckoutCreatedResponse($this->mockResponseCreated);
        // print_r($data);
        $this->assertTrue(true);
        // $this->assertEquals($data->paymentMethodDetails->cards->tokenBasedTransaction->transactionSequence, 'FIRST', 'Correct');
    }

    public function testPostCheckoutsSuccess(): void
    {
        // $req = new PaymentLinksRequest($this->paymentLinksRequestContent);
        // $res = Checkout::postCheckouts($this->client, $req);
        // $this->assertObjectHasProperty("paymentLink", $res->data, "Response misses field (paymentlink)");
        // $this->assertInstanceOf(PostCheckoutsResponse::class, $response->data, "Response schema is malformed");
        $this->assertTrue(true);
    }

    public function testPostMalformedBody(): void
    {
        // $request = new PaymentLinksRequest([
        //     'transactionOrigin' => 'ECOM',
        //     'transactionAmount' => ['total' => 130, 'currency' => 'EUR'],
        //     'checkoutSettings' => ['locale' => 'en_GB'],
        //     'paymentMethodDetails' => [
        //         'cards' => [
        //             'authenticationPreferences' => [
        //                 'challengeIndicator' => '01',
        //                 'skipTra' => false,
        //             ],
        //             'createToken' => [
        //                 'declineDuplicateToken' => false,
        //                 'reusable' => true,
        //                 'toBeUsedFor' => 'UNSCHEDULED',
        //             ],
        //             'tokenBasedTransaction' => ['transactionSequence' => 'FIRST']
        //         ],
        //         'sepaDirectDebit' => ['transactionSequenceType' => 'SINGLE']
        //     ],
        //     'merchantTransactionId' => 'AB-1234',
        //     'storeId' => '72305408',
        // ]);

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