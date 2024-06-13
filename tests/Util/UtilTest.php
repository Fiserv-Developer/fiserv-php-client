<?php

use Fiserv\FiservCheckoutClient;
use Fiserv\Fixtures;
use PHPUnit\Framework\TestCase;

class UtilTest extends TestCase
{
    public function testFieldStringValidationOnConstruction()
    {
        $badUrl = "BAD_URL";

        $this->expectExceptionMessage($badUrl . " is not a valid failureUrl");

        new CheckoutSettings([
            'redirectBackUrls' => [
                'successUrl' => 'https://www.successexample.com',
                'failureUrl' => $badUrl,
            ]
        ]);
    }

    public function testFieldStringValidationManually()
    {
        $badUrl = "BAD_URL";

        $this->expectExceptionMessage($badUrl . " is not a valid failureUrl");

        $settings = new CheckoutSettings([
            'redirectBackUrls' => [
                'successUrl' => 'https://www.successexample.com',
                'failureUrl' => 'https://www.successexample.com',
            ]
        ]);

        $settings->redirectBackUrls->failureUrl = $badUrl;
        $settings->redirectBackUrls->validate();
    }

    public function testFieldStringValidationOnRequest()
    {
        $badUrl = "BAD_URL";

        $this->expectExceptionMessage($badUrl . " is not a valid failureUrl");

        $req = new CheckoutClientRequest(Fixtures::paymentLinksRequestContent);
        $req->checkoutSettings->redirectBackUrls->failureUrl = $badUrl;

        $res = FiservCheckoutClient::postCheckouts($req);
    }
}
