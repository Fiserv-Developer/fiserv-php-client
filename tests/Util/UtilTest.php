<?php

use PHPUnit\Framework\TestCase;

class UtilTest extends TestCase
{
    public function testFieldStringValidation()
    {
        $badUrl = "BAD_URL";
        $this->expectExceptionMessage($badUrl . " is not a valid failureUrl");
        new redirectBackUrls([
            'successUrl' => 'https://www.successexample.com',
            'failureUrl' => $badUrl,
        ]);
    }
}
