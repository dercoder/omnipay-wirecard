<?php

namespace Omnipay\Wirecard\Message;

use Omnipay\Tests\TestCase;

class PurchaseResponseTest extends TestCase
{
    public function testRedirect()
    {
        $request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $response = new PurchaseResponse($request, array());

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isCancelled());
        $this->assertFalse($response->isPending());
        $this->assertTrue($response->isRedirect());
        $this->assertNull($response->getCode());
        $this->assertNull($response->getMessage());
        $this->assertNull($response->getTransactionId());
        $this->assertNull($response->getTransactionReference());
        $this->assertSame('https://checkout.wirecard.com/page/init.php', $response->getRedirectUrl());
        $this->assertSame('POST', $response->getRedirectMethod());
        $this->assertSame(array(), $response->getRedirectData());
    }
}
