<?php

use Fiserv\Checkout\CheckoutClient;
use Fiserv\Config\ApiConfig;
use Fiserv\Exception\RequiredFieldMissingException;
use Fiserv\Models\CheckoutClientRequest;
use Fiserv\Models\CheckoutClientResponse;
use Fiserv\Models\CreateToken;
use Fiserv\Models\GetCheckoutIdResponse;
use Fiserv\Tests\Fixtures;
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
        ApiConfig::$ORIGIN = 'PHP Unit';
        ApiConfig::$API_KEY = '7V26q9EbRO2hCmpWARdFtOyrJ0A4cHEP';
        ApiConfig::$API_SECRET = 'KCFGSj3JHY8CLOLzszFGHmlYQ1qI9OSqNEOUj24xTa0';
        ApiConfig::$STORE_ID = '72305408';
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
        $this->expectExceptionObject(new RequiredFieldMissingException("toBeUsedFor", CreateToken::class));

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

        $res = CheckoutClient::postCheckouts($req);
        $this->assertInstanceOf(CheckoutClientResponse::class, $res, "Response schema is malformed");
        $this->assertObjectHasProperty("checkout", $res, "Response misses field (checkout)");
    }

    public function testGetCheckoutIdSuccess(): void
    {
        $this->assertTrue(true);
        if ($this->DONT_TEST_API)
            return;

        $res = CheckoutClient::getCheckoutId($this->mockCheckoutId);
        $this->assertInstanceOf(GetCheckoutIdResponse::class, $res);
        $this->assertObjectHasProperty("storeId", $res, "Response misses field (storeId)");
    }

    public function testOrderWithSubcomponents(): void
    {
        $total = 29.99;

        $req = new CheckoutClientRequest(Fixtures::paymentLinksRequestContent);
        $req->transactionAmount->total = $total;
        $req->transactionAmount->components->subtotal = $total - 0.99;
        $req->transactionAmount->components->vatAmount = 0;
        $req->transactionAmount->components->shipping = 0.99;

        $res = CheckoutClient::postCheckouts($req);
        $id = $res->checkout->checkoutId;

        $details = CheckoutClient::getCheckoutId($id);
        $total_actual = $details->approvedAmount->total;

        $this->assertEquals($total, $total_actual);
    }

    public function testCreateBasicCheckout(): void
    {
        $request = CheckoutClient::createBasicCheckoutRequest(
            14.99,
            "https://success.com",
            "https://noooo.com"
        );

        $response = CheckoutClient::postCheckouts($request);
        $this->assertInstanceOf(CheckoutClientResponse::class, $response);
    }
}
