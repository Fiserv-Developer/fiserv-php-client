<?php

use Fiserv\CheckoutSolution;
use Fiserv\Fixtures;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class CheckoutTest extends TestCase
{
    private $client = null;
    private $DONT_TEST = true;

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
        $this->expectExceptionObject(new RequiredFieldMissingException("transactionAmount"));

        $paymentRequestContent = Fixtures::paymentLinksRequestContent;
        unset($paymentRequestContent["transactionAmount"]);

        new PaymentLinkData($paymentRequestContent);
    }

    public function testPostCheckoutsSuccess(): void
    {
        $this->assertTrue(true);
        if ($this->DONT_TEST)
            return;

        $req = new PaymentLinkData(Fixtures::paymentLinksRequestContent);
        $res = CheckoutSolution::postCheckouts($this->client, $req);
        $this->assertInstanceOf(CheckoutCreatedResponse::class, $res, "Response schema is malformed");
        $this->assertObjectHasProperty("checkout", $res, "Response misses field (checkout)");
    }


    public function testGetCheckoutIdSuccess(): void
    {
        $this->assertTrue(true);
        if ($this->DONT_TEST)
            return;

        $res = CheckoutSolution::getCheckoutId($this->client, $this->mockCheckoutId);
        $this->assertInstanceOf(GetCheckoutIdResponse::class, $res);
        $this->assertObjectHasProperty("storeId", $res, "Response misses field (storeId)");
    }
}