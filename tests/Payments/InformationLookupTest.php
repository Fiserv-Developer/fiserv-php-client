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
        $this->expectsRequest();
        static::assertInstanceOf(\Fiserv\Payments\Session::class, $requestBody);
    }

    protected function expectsRequest(
        $method,
        $path,
        $params,
        $header,
        $base
    ) {
        HttpClient::buildRequest();

        $this->prepareRequestMock($method, $path, $params, $header, $base)
            ->callbackPromise(
                function ($method, $absUrl, $headers, $params) {
                    $curlClient = HttpClient::class;
                    return $curlClient->request($method, $absUrl, $headers, $params);
                }
            );
    }
}