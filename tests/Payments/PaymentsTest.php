<?php

namespace Fisrv\Payments;

use Fisrv\Models\HealthCheckResponse;
use Fisrv\Models\PaymentsClientRequest;
use Fisrv\Models\PaymentsClientResponse;
use PHPUnit\Framework\TestCase;

class PaymentsTest extends TestCase
{
    private PaymentsClient $client;

    private static string $sharedTransactionId;

    protected function setUp(): void
    {
        $env = parse_ini_file('.env');

        if (!$env) {
            exit;
        }

        $this->client = new PaymentsClient([
            'is_prod' => false,
            'api_key' => $env['api_key'],
            'api_secret' => $env['api_secret'],
            'store_id' => $env['store_id']
        ]);
    }

    public function testCreatePaymentCardSaleTransaction(): void
    {
        $response = $this->client->createPaymentCardSaleTransaction(new PaymentsClientRequest([
            'transactionAmount' => ['total' => '13', 'currency' => "GBP"],
            'paymentMethod' => [
                'paymentCard' => [
                    'number' => '5424180279791732',
                    'securityCode' => "123",
                    'expiryDate' => ['month' => "02", 'year' => "29"],
                ],
            ],
        ]));

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

    public function testPingHealthCheck(): void
    {
        $this->assertInstanceOf(HealthCheckResponse::class, $this->client->reportHealthCheck());
    }

    public function testPingHealthCheckWithRequestLog(): void
    {
        $response = $this->client->reportHealthCheck(true);
        $this->assertInstanceOf(HealthCheckResponse::class, $response);
    }
}
