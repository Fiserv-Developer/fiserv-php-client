<?php

use Fisrv\Models\CheckoutClientRequest;
use Fisrv\Models\Fixtures;
use Fisrv\Models\GetPaymentLinkDetailsResponse;
use Fisrv\Models\PaymentsLinksCreatedResponse;
use Fisrv\PaymentLinks\PaymentLinksClient;
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
        $this->assertInstanceOf(PaymentsLinksCreatedResponse::class, $res, "Response schema is malformed");
    }

    public function testGetPaymentLinkDetails(): void
    {
        $res = $this->client->getPaymentLinkDetails($this->paymentLinkId);
        $this->assertInstanceOf(GetPaymentLinkDetailsResponse::class, $res);
    }
}
