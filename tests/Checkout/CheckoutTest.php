<?php

use Fiserv\CheckoutSolution;
use Fiserv\Fixtures;
use PHPUnit\Framework\TestCase;

class CheckoutTest extends TestCase
{
    private $client = null;
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
        // $this->client = curl_init();
    }

    public function testMissingFieldException(): void
    {
        $this->expectExceptionObject(new RequiredFieldMissingException("storeId", PaymentLinkRequestContent::class));

        $missingFieldContent = Fixtures::paymentLinksRequestContent;
        unset($missingFieldContent["storeId"]);

        new PaymentLinkRequestContent($missingFieldContent);
    }

    public function testNestedMissingFieldException(): void
    {
        $this->expectExceptionObject(new RequiredFieldMissingException("toBeUsedFor", createToken::class));

        $missingFieldContent = Fixtures::paymentLinksRequestContent;
        unset($missingFieldContent["paymentMethodDetails"]["cards"]["createToken"]["toBeUsedFor"]);

        new PaymentLinkRequestContent($missingFieldContent);
    }

    public function testPostCheckoutsSuccess(): void
    {
        $this->assertTrue(true);
        if ($this->DONT_TEST_API)
            return;

        $req = new PaymentLinkRequestContent(Fixtures::paymentLinksRequestContent);
        $res = CheckoutSolution::postCheckouts($req);
        $this->assertInstanceOf(CheckoutCreatedResponse::class, $res, "Response schema is malformed");
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
}