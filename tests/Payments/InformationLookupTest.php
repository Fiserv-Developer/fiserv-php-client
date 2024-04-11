<?php
use Fiserv\HttpClient;
use PHPUnit\Framework\TestCase;

final class InformationLookupTest extends TestCase
{

    public function testIsCreatable()
    {
        $requestBody = [
            'paymentCard' => [
                'number' => '2354289',
            ]
        ];
        $this->assertTrue(true);
    }

}