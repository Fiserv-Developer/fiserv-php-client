<?php

use Fiserv\Config\ApiConfig;
use Fiserv\Models\CheckoutClientRequest;
use Fiserv\Models\GetPaymentLinkDetailsResponse;
use Fiserv\Models\PaymentsLinksCreatedResponse;
use Fiserv\PaymentLinks\PaymentLinksClient;
use Fiserv\Tests\Fixtures;
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
        ApiConfig::$ORIGIN = 'PHP Unit';
        ApiConfig::$API_KEY = '7V26q9EbRO2hCmpWARdFtOyrJ0A4cHEP';
        ApiConfig::$API_SECRET = 'KCFGSj3JHY8CLOLzszFGHmlYQ1qI9OSqNEOUj24xTa0';
        ApiConfig::$STORE_ID = '72305408';
    }

    public function testCreatePaymentLinkSuccess(): void
    {
        $this->assertTrue(true);
        $req = new CheckoutClientRequest(Fixtures::paymentLinksRequestContent);
        $res = PaymentLinksClient::createPaymentLink($req);
        $this->assertInstanceOf(PaymentsLinksCreatedResponse::class, $res, "Response schema is malformed");
    }

    public function testGetPaymentLinkDetails(): void
    {
        $this->assertTrue(true);
        $res = new GetPaymentLinkDetailsResponse(Fixtures::paymentlinkResponseContent);
        $res = PaymentLinksClient::getPaymentLinkDetails($this->paymentLinkId);
        $this->assertInstanceOf(GetPaymentLinkDetailsResponse::class, $res);
    }
}
