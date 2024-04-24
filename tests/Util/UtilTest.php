<?php

use Fiserv\CheckoutSolution;
use Fiserv\Fixtures;
use PHPUnit\Framework\TestCase;

class UtilTest extends TestCase
{
    public function testPostCheckoutsSuccess(): void
    {
        $this->assertTrue(true);
        $req = new PaymentLinkRequestBody(Fixtures::paymentLinksRequestContent);
        $res = CheckoutSolution::postCheckouts($req);
        $this->assertInstanceOf(PostCheckoutsResponse::class, $res, "Response schema is malformed");
        $this->assertObjectHasProperty("checkout", $res, "Response misses field (checkout)");
    }
}
