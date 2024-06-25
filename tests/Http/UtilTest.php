<?php

use Fisrv\Models\CheckoutSettings;
use PHPUnit\Framework\TestCase;

class UtilTest extends TestCase
{
    public function testFieldStringValidationOnRequest(): void
    {
        $badUrl = "BAD_URL";

        $this->expectExceptionMessage($badUrl . " value could not be validated as field failureUrl.");

        $settings = new CheckoutSettings([
            'redirectBackUrls' => [
                'successUrl' => 'https://www.successexample.com',
                'failureUrl' => 'https://www.successexample.com',
            ]
        ]);

        $settings->redirectBackUrls->failureUrl = $badUrl;
        $settings->redirectBackUrls->validate();
    }
}
