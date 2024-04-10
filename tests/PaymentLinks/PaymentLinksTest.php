<?php
use Fiserv\models\FiservObject;
use Fiserv\PaymentLinks\PaymentLinks;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class PaymentLinksTest extends TestCase
{
    private $client = null;

    protected function setUp(): void
    {
        $this->client = new Client();
    }

    public function testCreatePaymentLinkSuccessResponse(): void
    {
        $req = new PaymentLinksRequest(json_encode([
            'transactionOrigin' => 'ECOM',
            'transactionType' => 'SALE',
            'transactionAmount' => ['total' => 130, 'currency' => 'EUR'],
            'checkoutSettings' => ['locale' => 'en_GB'],
            'paymentMethodDetails' => [
                'cards' => [
                    'authenticationPreferences' => ['challengeIndicator' => '01', 'skipTra' => false],
                    'createToken' => ['declineDuplicateToken' => false, 'reusable' => true, 'toBeUsedFor' => 'UNSCHEDULED'],
                    'tokenBasedTransaction' => ['transactionSequence' => 'FIRST']
                ],
                'sepaDirectDebit' => ['transactionSequenceType' => 'SINGLE']
            ],
            'storeId' => '72305408'
        ]));

        $mockResponseCreated = [
            "paymentLink" => [
                "storeId" => "72305408",
                "orderId" => "31da1addc129a",
                "paymentLinkId" => "dBpYUi",
                "paymentLinkUrl" => "https=>//www.checkout-lane.com/pl/dBpYUi",
                "expiryDateTime" => "2022-08-23T10=>56=>27.561Z"
            ]
        ];

        $response = PaymentLinks::createPaymentLink($this->client, $req);
        $this->assertEquals($response->statusCode, 200);
        $this->assertInstanceOf(PaymentsLinksCreatedResponse::class, $response->data);
    }

    // public function testGetPaymentLinkDetailsSuccessResponse(): void
    // {
    //     $response = PaymentLinks::getPaymentLinkDetails($this->client, 'dBpYUi');
    //     $this->assertInstanceOf(GetPaymentLinkDetailsResponse::class, new GetPaymentLinkDetailsResponse(json_encode($response)));
    // }
}

final class GetPaymentLinkDetailsResponse extends FiservObject
{

}


