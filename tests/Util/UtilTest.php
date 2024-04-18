<?php
use Fiserv\CheckoutSolution;
use Fiserv\Fixtures;
use Fiserv\HttpClient;
use Fiserv\RequestType;
use PHPUnit\Framework\TestCase;

class UtilTest extends TestCase
{
    public function testCurlRequest(): void
    {
        $url = 'https://jsonplaceholder.typicode.com/posts/1';
        $res = HttpClient::curlRequest(RequestType::GET, $url);
        $this->assertIsObject(json_decode($res));
    }
}