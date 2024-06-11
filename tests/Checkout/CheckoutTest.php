<?php

use Fiserv\CheckoutSolution;
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
        $this->expectExceptionObject(new RequiredFieldMissingException("storeId", CreateCheckoutRequest::class));

        $missingFieldContent = Fixtures::paymentLinksRequestContent;
        unset($missingFieldContent["storeId"]);

        new CreateCheckoutRequest($missingFieldContent);
    }

    public function testNestedMissingFieldException(): void
    {
        $this->expectExceptionObject(new RequiredFieldMissingException("toBeUsedFor", createToken::class));

        $missingFieldContent = Fixtures::paymentLinksRequestContent;
        unset($missingFieldContent["paymentMethodDetails"]["cards"]["createToken"]["toBeUsedFor"]);

        new CreateCheckoutRequest($missingFieldContent);
    }

    public function testPostCheckoutsSuccess(): void
    {
        $this->assertTrue(true);
        if ($this->DONT_TEST_API)
            return;

        $req = new CreateCheckoutRequest(Fixtures::paymentLinksRequestContent);

        $res = CheckoutSolution::postCheckouts($req);
        $this->assertInstanceOf(PostCheckoutsResponse::class, $res, "Response schema is malformed");
        $this->assertObjectHasProperty("checkout", $res, "Response misses field (checkout)");
    }

    public function testGetCheckoutIdSuccess(): void
    {
        $this->assertTrue(true);
        if ($this->DONT_TEST_API)
            return;

        $res = CheckoutSolution::getCheckoutId($this->mockCheckoutId);
        $this->assertInstanceOf(GetCheckoutIdResponse::class, $res);
        $this->assertObjectHasProperty("storeId", $res, "Response misses field (storeId)");
    }

    public function testFloatAmountSetter(): void
    {
        $total = 29.99;

        $req = new CreateCheckoutRequest(Fixtures::paymentLinksRequestContent);
        $req->transactionAmount->total = $total;
        $req->transactionAmount->components->subtotal = $total - 0.99;
        $req->transactionAmount->components->vatAmount = 0;
        $req->transactionAmount->components->shipping = 0.99;

        $res = CheckoutSolution::postCheckouts($req);
        $id = $res->checkout->checkoutId;

        $details = CheckoutSolution::getCheckoutId($id);
        $total_actual = $details->approvedAmount->total;

        $this->assertEquals($total, $total_actual);
    }

    public function testCreateSEPACheckout(): void
    {
        $res = CheckoutSolution::createSEPACheckout(
            14.99,
            "https://success.com",
            "https://failure.com",
            new components([
                'shipping' => 0.99,
                'vatAmount' => 2,
                'subtotal' => 12,
            ])
        );

        $this->assertInstanceOf(PostCheckoutsResponse::class, $res);
    }
}
