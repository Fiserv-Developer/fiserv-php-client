<?php

use Fisrv\Models\CheckoutClientRequest;
use Fisrv\Models\GetPaymentLinkDetailsResponse;
use Fisrv\Models\PaymentsLinksCreatedResponse;
use Fisrv\PaymentLinks\PaymentLinksClient;
use PHPUnit\Framework\TestCase;

class PaymentLinksTest extends TestCase
{
    private const paymentLinksRequestContent = [
        'transactionOrigin' => 'ECOM',
        'transactionType' => 'SALE',
        'transactionAmount' => [
            'total' => 130,
            'currency' => 'EUR',
            'components' => [
                'subtotal' => 130,
                'vatAmount' => 0,
                'shipping' => 0,
            ]
        ],
        'checkoutSettings' => [
            'locale' => 'en_GB',
            'webHooksUrl' => 'https://www.success.com/',
            'redirectBackUrls' => [
                'successUrl' => "https://www.success.com/",
                'failureUrl' => "https://www.failureexample.com"
            ]
        ],
        'paymentMethodDetails' => [
            'cards' => [
                'authenticationPreferences' => [
                    'challengeIndicator' => '01',
                    'skipTra' => false,
                ],
                'createToken' => [
                    'declineDuplicateToken' => false,
                    'reusable' => true,
                    'toBeUsedFor' => 'UNSCHEDULED',
                ],
                'tokenBasedTransaction' => ['transactionSequence' => 'FIRST']
            ],
            'sepaDirectDebit' => ['transactionSequenceType' => 'SINGLE']
        ],
        'merchantTransactionId' => 'AB-1234',
    ];

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
        $req = new CheckoutClientRequest(self::paymentLinksRequestContent);
        $res = $this->client->createPaymentLink($req);
        $this->assertInstanceOf(PaymentsLinksCreatedResponse::class, $res, "Response schema is malformed");
    }

    public function testGetPaymentLinkDetails(): void
    {
        $res = $this->client->getPaymentLinkDetails($this->paymentLinkId);
        $this->assertInstanceOf(GetPaymentLinkDetailsResponse::class, $res);
    }
}
