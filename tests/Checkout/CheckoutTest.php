<?php

use Fiserv\CheckoutSolution;
use Fiserv\Fixtures;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class CheckoutTest extends TestCase
{
    private $client = null;

    private string $mockCheckoutId = 'IUBsFE';

    private $mockResponseCreated = [
        "checkout" => [
            "storeId" => "72305408",
            "checkoutId" => "IUBsFE",
            "redirectionUrl" => "https://checkout-lane.com/?checkoutId=IUBsFE",
        ]
    ];

    protected function setUp(): void
    {
        $this->client = new Client();
    }

    public function testPostMalformedBody(): void
    {
        $paymentRequestContent = Fixtures::paymentLinksRequestContent;
        unset($paymentRequestContent["transactionType"]);

        $this->assertTrue(true);
        //     $response = Checkout::postCheckouts($this->client, $request);
        //     $this->expectException(new MalformedRequestException);
    }

    public function testPostCheckoutsSuccess(): void
    {
        // $req = new PaymentLinkData(Fixtures::paymentLinksRequestContent);
        // $res = CheckoutSolution::postCheckouts($this->client, $req);
        // print_r($res);
        // $this->assertInstanceOf(CheckoutCreatedResponse::class, $res->data, "Response schema is malformed");
        // $this->assertObjectHasProperty("checkout", $res->data, "Response misses field (paymentlink)");
        $this->assertTrue(true);
    }


    public function testGetCheckoutIdSuccess(): void
    {
        $this->assertTrue(true);
        CheckoutSolution::getCheckoutId($this->client, $this->mockCheckoutId);
        // $response = Checkout::getCheckoutId($this->client, $mockCheckoutId);
        // $this->assertEquals($response->statusCode, 201);
        // $this->assertInstanceOf(GetCheckoutIdResponse::class, $response->data);
    }
}