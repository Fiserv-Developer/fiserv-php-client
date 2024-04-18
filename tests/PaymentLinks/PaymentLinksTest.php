<?php

use Fiserv\Fixtures;
use Fiserv\PaymentLinks\PaymentLinks;
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
        // $this->client = curl_init();
    }

    public function testCreatePaymentLinkSuccess(): void
    {
        $this->assertTrue(true);
        $req = new PaymentLinkRequestContent(Fixtures::paymentLinksRequestContent);
        $res = PaymentLinks::createPaymentLink($req);
        $this->assertInstanceOf(PaymentsLinksCreatedResponse::class, $res, "Response schema is malformed");
    }

    public function testGetPaymentLinkDetails(): void
    {
        $this->assertTrue(true);
        $res = new GetPaymentLinkDetailsResponse(Fixtures::paymentlinkResponseContent);
        $res = PaymentLinks::getPaymentLinkDetails($this->paymentLinkId);
        $this->assertInstanceOf(GetPaymentLinkDetailsResponse::class, $res);
    }
}