<?php

use Fiserv\HttpClient\HttpClient;
use Fiserv\HttpClient\RequestType;
use Fiserv\Models\CheckoutClientRequest;
use Fiserv\Models\WebhookEvent\WebhookEvent;
use Fiserv\Tests\Fixtures;
use PHPUnit\Framework\TestCase;

class WebhookTest extends TestCase
{
    private bool $mock_active = false;
    private string $node_events = 'http://localhost:3000/init';
    private string $consumer = 'http://fiserv-wp-dev.local/wp-json/fiserv_woocommerce_plugin/v1/events';

    public function testSimulatedHookEvents(): void
    {
        if (!$this->mock_active) {
            $this->assertTrue(true);
            return;
        }

        $req = new CheckoutClientRequest(Fixtures::paymentLinksRequestContent);
        $req->checkoutSettings->webHooksUrl = 'http://fiserv-wp-dev.local/wp-json/fiserv_woocommerce_plugin/v1/events';
        $req->orderId = '99';

        $nodeRes = HttpClient::externalCurlRequest(RequestType::POST, $this->node_events, '{"webHooksUrl": "' . $this->consumer . '"}');
        $nodeResWebhookUrl = json_decode($nodeRes['data'], 1)['webHooksUrl'];

        // $res = CheckoutSolution::postCheckoutsWithSimulatedMock($req);
        // $this->assertInstanceOf(PostCheckoutsResponse::class, $res, "Response schema is malformed");
        $this->assertEquals($nodeResWebhookUrl, $this->consumer);
    }

    public function testWebhookParsing(): void
    {
        $eventData = '{
            "retryNumber": 0,
            "storeId": "12345678",
            "checkoutId": "5qnq1E",
            "orderId": "a5e5ce31-4adc-44ca-8618-b27aafe6942e",
            "transactionType": "SALE",
            "approvedAmount": {
                "total": 25,
                "currency": "EUR",
                "components": {
                    "subtotal": 20,
                    "vatAmount": 2,
                    "shipping": 3
                }
            },
            "transactionStatus": "PARTIAL",
            "paymentMethodUsed": {
                "cards": {
                    "cardNumber": "123456******7890",
                    "expiryDate": {
                        "month": "12",
                        "year": "2024"
                    },
                    "brand": "VISA"
                }
            },
            "ipgTransactionDetails": {
                "ipgTransactionId": "84632773344",
                "transactionStatus": "APPROVED",
                "approvalCode": "Y:758396:4632773344:YYYM:032018"
            }
        }';

        $webhookEvent = new WebhookEvent($eventData);

        $this->assertInstanceOf(WebhookEvent::class, $webhookEvent);
    }
}
