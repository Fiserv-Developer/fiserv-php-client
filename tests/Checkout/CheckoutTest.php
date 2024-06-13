<?php

use Fiserv\FiservCheckoutClient;
use Fiserv\Fixtures;
use PHPUnit\Framework\TestCase;

class CheckoutTest extends TestCase
{
    private $DONT_TEST_API = false;
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
        Config::$ORIGIN = 'PHP Unit';
        Config::$API_KEY = '7V26q9EbRO2hCmpWARdFtOyrJ0A4cHEP';
        Config::$API_SECRET = 'KCFGSj3JHY8CLOLzszFGHmlYQ1qI9OSqNEOUj24xTa0';
        Config::$STORE_ID = '72305408';
    }

    public function testMissingFieldException(): void
    {
        $this->expectExceptionObject(new RequiredFieldMissingException("storeId", CheckoutClientRequest::class));

        $missingFieldContent = Fixtures::paymentLinksRequestContent;
        unset($missingFieldContent["storeId"]);

        new CheckoutClientRequest($missingFieldContent);
    }

    public function testNestedMissingFieldException(): void
    {
        $this->expectExceptionObject(new RequiredFieldMissingException("toBeUsedFor", createToken::class));

        $missingFieldContent = Fixtures::paymentLinksRequestContent;
        unset($missingFieldContent["paymentMethodDetails"]["cards"]["createToken"]["toBeUsedFor"]);

        new CheckoutClientRequest($missingFieldContent);
    }

    public function testPostCheckoutsSuccess(): void
    {
        $this->assertTrue(true);
        if ($this->DONT_TEST_API)
            return;

        $req = new CheckoutClientRequest(Fixtures::paymentLinksRequestContent);

        $res = FiservCheckoutClient::postCheckouts($req);
        $this->assertInstanceOf(PostCheckoutsResponse::class, $res, "Response schema is malformed");
        $this->assertObjectHasProperty("checkout", $res, "Response misses field (checkout)");
    }

    public function testGetCheckoutIdSuccess(): void
    {
        $this->assertTrue(true);
        if ($this->DONT_TEST_API)
            return;

        $res = FiservCheckoutClient::getCheckoutId($this->mockCheckoutId);
        $this->assertInstanceOf(GetCheckoutIdResponse::class, $res);
        $this->assertObjectHasProperty("storeId", $res, "Response misses field (storeId)");
    }

    public function testFloatAmountSetter(): void
    {
        $total = 29.99;

        $req = new CheckoutClientRequest(Fixtures::paymentLinksRequestContent);
        $req->transactionAmount->total = $total;
        $req->transactionAmount->components->subtotal = $total - 0.99;
        $req->transactionAmount->components->vatAmount = 0;
        $req->transactionAmount->components->shipping = 0.99;

        $res = FiservCheckoutClient::postCheckouts($req);
        $id = $res->checkout->checkoutId;

        $details = FiservCheckoutClient::getCheckoutId($id);
        $total_actual = $details->approvedAmount->total;

        $this->assertEquals($total, $total_actual);
    }

    public function testCreateBasicCheckout(): void
    {
        $request = FiservCheckoutClient::createBasicCheckoutRequest(
            14.99,
            "https://success.com",
            "https://noooo.com"
        );

        $response = FiservCheckoutClient::postCheckouts($request);
        $this->assertInstanceOf(GetCheckoutIdResponse::class, $response);
    }
}
