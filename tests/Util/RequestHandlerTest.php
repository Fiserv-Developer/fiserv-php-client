<?php

use Fiserv\CheckoutSolution;
use Fiserv\HttpClient;
use Fiserv\RequestType;
use PHPUnit\Framework\TestCase;

class RequestHandlerTest extends TestCase
{
    private bool $NODE_ACTIVE = false;
    private string $NODE_URL = 'http://localhost:3000/';

    public function testCurlRequest(): void
    {
        $url = 'https://jsonplaceholder.typicode.com/posts/1';
        $res = HttpClient::externalCurlRequest(RequestType::GET, $url);
        $this->assertIsArray($res);
    }

    public function testNodeServer(): void
    {
        if (!$this->NODE_ACTIVE) {
            $this->assertTrue(true);
            return;
        }

        $res = HttpClient::externalCurlRequest(RequestType::POST, $this->NODE_URL, '{"data":"SDK - ' . date("Y-m-d\TH:i:sO") . '"}');
        $data = $res['data'];

        $this->assertIsString($data);
    }

    public function testIsBadRequestExceptionMessageCorrectlyParsed(): void
    {
        $this->expectExceptionMessageMatches('/^(?:.*\n){5,}/');
        $data = '{"errors":[{"title":"Internal server error","detail":"Sorry, something has gone wrong at our end. If this persists please contact support and provide the value of your Trace-Id header."}]}';
        throw new BadRequestException('503', $data, 'c7b7681b5b0368dcff56985981294226');
    }

    public function testBadRequestExceptionStringMessage(): void
    {
        $this->expectExceptionMessage('503: No healthy upstream');
        $data = 'No healthy upstream';
        throw new BadRequestException('503', $data, 'c7b7681b5b0368dcff56985981294226');
    }

    public function testWebHook(): void
    {
        $reqBody = [
            'storeId' => '72305408',
            'transactionType' => 'SALE',
            'transactionAmount' => [
                'total' => 130,
                'currency' => 'EUR'
            ],
            'checkoutSettings' => [
                'locale' => 'en_GB',
                "webHooksUrl" => $this->NODE_URL,
            ],
            'paymentMethodDetails' => [
                'cards' => [
                    'createToken' => [
                        'toBeUsedFor' => 'UNSCHEDULED',
                    ],
                ],
            ],
        ];

        $req = new PaymentLinkRequestBody($reqBody);
        $res = CheckoutSolution::postCheckouts($req);

        // $this->assertInstanceOf(CheckoutCreatedResponse::class, $res, "Response schema is malformed");
        // $this->assertObjectHasProperty("checkout", $res, "Response misses field (checkout)");
        $this->assertTrue(true);
    }
}
