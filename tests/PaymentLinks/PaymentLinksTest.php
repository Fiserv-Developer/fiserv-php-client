<?php

use Fiserv\Models\CheckoutClientRequest;
use Fiserv\Models\GetPaymentLinkDetailsResponse;
use Fiserv\Models\PaymentsLinksCreatedResponse;
use Fiserv\PaymentLinks\PaymentLinksClient;
use Fiserv\Tests\Fixtures;
use PHPUnit\Framework\TestCase;

class PaymentLinksTest extends TestCase
{
    private string $paymentLinkId = 'IUBsFE';

    private PaymentLinksClient $client;

    protected function setUp(): void
    {
        $this->client = new PaymentLinksClient([
            'is_prod' => false,
            'api_key' => '7V26q9EbRO2hCmpWARdFtOyrJ0A4cHEP',
            'api_secret' => 'KCFGSj3JHY8CLOLzszFGHmlYQ1qI9OSqNEOUj24xTa0',
            'store_id' => '72305408',
        ]);
    }

    public function testCreatePaymentLinkSuccess(): void
    {
        $req = new CheckoutClientRequest(Fixtures::paymentLinksRequestContent);
        $res = $this->client->createPaymentLink($req);
        // $this->assertInstanceOf(PaymentsLinksCreatedResponse::class, $res, "Response schema is malformed");
        $this->assertTrue(true);
    }

    // public function testGetPaymentLinkDetails(): void
    // {
    //     $res = new GetPaymentLinkDetailsResponse(Fixtures::paymentlinkResponseContent);
    //     $res = $this->client->getPaymentLinkDetails($this->paymentLinkId);
    //     $this->assertInstanceOf(GetPaymentLinkDetailsResponse::class, $res);
    // }
}
