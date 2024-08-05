<?php

use Fisrv\Checkout\CheckoutClient;
use Fisrv\Exception\RequiredFieldMissingException;
use Fisrv\Models\CheckoutClientRequest;
use Fisrv\Models\CheckoutClientResponse;
use Fisrv\Models\CreateToken;
use Fisrv\Models\GetCheckoutIdResponse;
use PHPUnit\Framework\TestCase;

class CheckoutTest extends TestCase
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
        'storeId' => '72305408',
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

    public function testMissingFieldException(): void
    {
        $this->expectExceptionObject(new RequiredFieldMissingException("transactionType", CheckoutClientRequest::class));

        $missingFieldContent = self::paymentLinksRequestContent;
        unset($missingFieldContent["transactionType"]);

        new CheckoutClientRequest($missingFieldContent);
    }

    public function testNestedMissingFieldException(): void
    {
        $this->expectExceptionObject(new RequiredFieldMissingException("toBeUsedFor", CreateToken::class));

        $missingFieldContent = self::paymentLinksRequestContent;
        unset($missingFieldContent["paymentMethodDetails"]["cards"]["createToken"]["toBeUsedFor"]);

        new CheckoutClientRequest($missingFieldContent);
    }

    public function testPostCheckoutsSuccess(): void
    {
        $req = new CheckoutClientRequest(self::paymentLinksRequestContent);

        $res = $this->client->createCheckout($req);
        $this->assertInstanceOf(CheckoutClientResponse::class, $res, "Response schema is malformed");
        $this->assertObjectHasProperty("checkout", $res, "Response misses field (checkout)");
    }

    public function testOrderWithSubcomponents(): void
    {
        $total = 130;

        $req = new CheckoutClientRequest(self::paymentLinksRequestContent);
        $req->transactionAmount->total = $total;
        $req->transactionAmount->components->subtotal = $total - 0.99;
        $req->transactionAmount->components->vatAmount = 0;
        $req->transactionAmount->components->shipping = 0.99;

        $res = $this->client->createCheckout($req);
        $id = $res->checkout->checkoutId;

        $details = $this->client->getCheckoutById($id);
        $total_actual = $details->approvedAmount->total;

        $this->assertEquals($total, $total_actual);
    }

    public function testGetCheckoutIdSuccess(): void
    {
        $res = $this->client->getCheckoutById('IUBsFE');
        $this->assertInstanceOf(GetCheckoutIdResponse::class, $res);
        $this->assertObjectHasProperty("storeId", $res, "Response misses field (storeId)");
    }
}
