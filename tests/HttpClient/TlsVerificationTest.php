<?php

namespace Fisrv\HttpClient;

use PHPUnit\Framework\TestCase;

class TlsVerificationTest extends TestCase
{
    public function testCertificateAndHostnameVerificationAreEnabled(): void
    {
        $options = (new \ReflectionClass(HttpClient::class))
            ->getReflectionConstant('DEFAULT_CURL_OPTIONS')
            ->getValue();

        $this->assertSame(2, $options[CURLOPT_SSL_VERIFYHOST]);
        $this->assertTrue($options[CURLOPT_SSL_VERIFYPEER]);
    }
}
