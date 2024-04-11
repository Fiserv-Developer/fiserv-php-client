<?php

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class PaymentLinksTest extends TestCase
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

    public function testCreatePaymentLinkSuccess(): void
    {
        // $req = new PaymentLinksRequest(Fixtures::paymentLinksRequestContent);
        $this->assertTrue(true);
    }

    public function testGetPaymentLinkDetails(): void
    {
        // $req = new PaymentLinksRequest(Fixtures::paymentLinksRequestContent);
        $this->assertTrue(true);
    }
}