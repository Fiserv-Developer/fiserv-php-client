<?php

namespace Fisrv\Checkout;

use Fisrv\Models\WebhookEvent\WebhookEvent;
use PHPUnit\Framework\TestCase;

class WebhookTest extends TestCase
{
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
