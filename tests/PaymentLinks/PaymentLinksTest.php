<?php

use Fiserv\Fixtures;
use Fiserv\PaymentLinks\PaymentLinks;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class PaymentLinksTest extends TestCase
{
    private $client = null;

    private string $paymentLinkId = 'IUBsFE';


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

    public function testCreatePaymentLinkSuccess(): void
    {
        $req = new PaymentLinkRequestContent(Fixtures::paymentLinksRequestContent);
        $res = PaymentLinks::createPaymentLink($this->client, $req);
        $this->assertTrue(true);
    }

    public function testGetPaymentLinkDetails(): void
    {
        $res = PaymentLinks::getPaymentLinkDetails($this->client, $this->paymentLinkId);
        $this->assertInstanceOf(GetCheckoutIdResponse::class, $res);
        $this->assertObjectHasProperty("storeId", $res, "Response misses field (storeId)");
    }
}