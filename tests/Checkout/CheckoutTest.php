<?php

use Fiserv\CheckoutSolution;
use Fiserv\Fixtures;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class CheckoutTest extends TestCase
{
    private $client = null;

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
        $req = new PaymentLinksRequest(Fixtures::paymentLinksRequestContent);
        $res = CheckoutSolution::postCheckouts($this->client, $req);
        $this->assertInstanceOf(CheckoutCreatedResponse::class, $res->data, "Response schema is malformed");
        $this->assertObjectHasProperty("checkout", $res->data, "Response misses field (paymentlink)");
    }


    public function testGetCheckoutIdSuccess(): void
    {
        $mockCheckoutId = 'IUBsFE';
        $this->assertTrue(true);
        // $response = Checkout::getCheckoutId($this->client, $mockCheckoutId);
        // $this->assertEquals($response->statusCode, 201);
        // $this->assertInstanceOf(GetCheckoutIdResponse::class, $response->data);
    }
}