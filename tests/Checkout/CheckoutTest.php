<?php

use Composer\InstalledVersions;
use Fiserv\Checkout\CheckoutClient;
use Fiserv\Exception\RequiredFieldMissingException;
use Fiserv\Models\CheckoutClientRequest;
use Fiserv\Models\CheckoutClientResponse;
use Fiserv\Models\CreateToken;
use Fiserv\Models\GetCheckoutIdResponse;
use Fiserv\Tests\Fixtures;
use PHPUnit\Framework\TestCase;

class CheckoutTest extends TestCase
{
    private string $mockCheckoutId = 'IUBsFE';

    private $mockResponseCreated = [
        "checkout" => [
            "storeId" => "72305408",
            "checkoutId" => "IUBsFE",
            "redirectionUrl" => "https://checkout-lane.com/?checkoutId=IUBsFE",
        ]
    ];

    private CheckoutClient $client;

    protected function setUp(): void
    {
        $this->client = new CheckoutClient([
            'is_prod' => false,
            'api_key' => '7V26q9EbRO2hCmpWARdFtOyrJ0A4cHEP',
            'api_secret' => 'KCFGSj3JHY8CLOLzszFGHmlYQ1qI9OSqNEOUj24xTa0',
            'store_id' => '72305408',
        ]);
    }

    // public function testMissingFieldException(): void
    // {
    //     $this->expectExceptionObject(new RequiredFieldMissingException("storeId", CheckoutClientRequest::class));

    //     $missingFieldContent = Fixtures::paymentLinksRequestContent;
    //     unset($missingFieldContent["storeId"]);

    //     new CheckoutClientRequest($missingFieldContent);
    // }

    // public function testNestedMissingFieldException(): void
    // {
    //     $this->expectExceptionObject(new RequiredFieldMissingException("toBeUsedFor", CreateToken::class));

    //     $missingFieldContent = Fixtures::paymentLinksRequestContent;
    //     unset($missingFieldContent["paymentMethodDetails"]["cards"]["createToken"]["toBeUsedFor"]);

    //     new CheckoutClientRequest($missingFieldContent);
    // }

    // public function testPostCheckoutsSuccess(): void
    // {
    //     $req = new CheckoutClientRequest(Fixtures::paymentLinksRequestContent);

    //     $res = $this->client->createCheckout($req);
    //     $this->assertInstanceOf(CheckoutClientResponse::class, $res, "Response schema is malformed");
    //     $this->assertObjectHasProperty("checkout", $res, "Response misses field (checkout)");
    // }

    // public function testGetCheckoutIdSuccess(): void
    // {
    //     $res = $this->client->getCheckoutId($this->mockCheckoutId);
    //     $this->assertInstanceOf(GetCheckoutIdResponse::class, $res);
    //     $this->assertObjectHasProperty("storeId", $res, "Response misses field (storeId)");
    // }

    public function testOrderWithSubcomponents(): void
    {
        $total = 130;

        $req = new CheckoutClientRequest(Fixtures::paymentLinksRequestContent);
        $req->transactionAmount->total = $total;
        $req->transactionAmount->components->subtotal = $total - 0.99;
        $req->transactionAmount->components->vatAmount = 0;
        $req->transactionAmount->components->shipping = 0.99;

        $res = $this->client->createCheckout($req);
        $id = $res->checkout->checkoutId;

        $details = $this->client->getCheckoutId($id);
        // $total_actual = $details->approvedAmount->total;

        // $this->assertEquals($total, $total_actual);
        $this->assertIsString($id);
    }

    // public function testCreateBasicCheckout(): void
    // {
    //     $request = $this->client->createBasicCheckoutRequest(
    //         14.99,
    //         "https://success.com",
    //         "https://noooo.com"
    //     );

    //     $response = $this->client->createCheckout($request);
    //     $this->assertInstanceOf(CheckoutClientResponse::class, $response);
    // }
}
