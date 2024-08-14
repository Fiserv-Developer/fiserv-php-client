<?php

use Fisrv\Checkout\CheckoutClient;
use Fisrv\Exception\ErrorResponse;
use Fisrv\Models\CheckoutSettings;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    private CheckoutClient $client;

    protected function setUp(): void
    {
        $this->client = new CheckoutClient([
            'is_prod' => false,
            'api_key' => '7V26q9EbRO2hCmpWARdFtOyrJ0A4cHEPd',
            'api_secret' => 'KCFGSj3JHY8CLOLzszFGHmlYQ1qI9OSqNEOUj24xTa0',
            'store_id' => '72305408',
        ]);
    }

    public function testFieldStringValidationOnRequest(): void
    {
        $badUrl = "BAD_URL";

        $this->expectExceptionMessage($badUrl . " value could not be validated as field failureUrl.");

        $settings = new CheckoutSettings([
            'redirectBackUrls' => [
                'successUrl' => 'https://www.successexample.com',
                'failureUrl' => 'https://www.successexample.com'
            ]
        ]);

        $settings->redirectBackUrls->failureUrl = $badUrl;
        $settings->redirectBackUrls->validate();
    }

    public function testErrorResponseGeneric(): void
    {
        $this->expectExceptionMessage('No valid API key or credential has been provided in the request.');
        $this->assertTrue(true);

        $this->client->createCheckout(CheckoutClient::createBasicCheckoutRequest(0, 'https://www.successexample.com', 'https://www.successexample.com'));
    }
}
