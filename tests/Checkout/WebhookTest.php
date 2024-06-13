<?php

use Fiserv\FiservCheckoutClient;
use Fiserv\Fixtures;
use Fiserv\HttpClient;
use Fiserv\RequestType;
use PHPUnit\Framework\TestCase;

class WebhookTest extends TestCase
{
    private bool $mock_active = false;
    private string $node_events = 'http://localhost:3000/init';
    private string $consumer = 'http://fiserv-wp-dev.local/wp-json/fiserv_woocommerce_plugin/v1/events';

    public function testSimulatedHookEvents()
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
}
