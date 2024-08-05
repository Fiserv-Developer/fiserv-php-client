<?php

use Fisrv\Models\PaymentsClientRequest;
use Fisrv\Models\PaymentsClientResponse;
use Fisrv\Payments\PaymentsClient;
use PHPUnit\Framework\TestCase;

class PaymentsTest extends TestCase
{
    private PaymentsClient $client;

    private static string $sharedTransactionId;

    protected function setUp(): void
    {
        $this->client = new PaymentsClient([
            'is_prod' => false,
            'api_key' => '7V26q9EbRO2hCmpWARdFtOyrJ0A4cHEP',
            'api_secret' => 'KCFGSj3JHY8CLOLzszFGHmlYQ1qI9OSqNEOUj24xTa0',
            'store_id' => '72305408',
        ]);
    }

    public function testCreatePaymentCardSaleTransaction(): void
    {
        $request = new PaymentsClientRequest([
            'transactionAmount' => ['total' => '13', 'currency' => "GBP"],
            'paymentMethod' => [
                'paymentCard' => [
                    'number' => '5424180279791732',
                    'securityCode' => "123",
                    'expiryDate' => ['month' => "02", 'year' => "29"],
                ],
            ],
        ]);

        $response = $this->client->createPaymentCardSaleTransaction($request);
        self::$sharedTransactionId = $response->ipgTransactionId;

        $this->assertInstanceOf(PaymentsClientResponse::class, $response, "Response schema is malformed");
    }

    public function testReturnTransaction(): void
    {
        $response = $this->client->returnTransaction(new PaymentsClientRequest([
            'transactionAmount' => [
                'total' => 3,
                'currency' => "GBP"
            ],
        ]), self::$sharedTransactionId);
        $this->assertInstanceOf(PaymentsClientResponse::class, $response, "Response schema is malformed");
    }
}
