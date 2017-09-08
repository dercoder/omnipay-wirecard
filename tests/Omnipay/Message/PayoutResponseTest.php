<?php

namespace Omnipay\Wirecard\Message;

use Omnipay\Tests\TestCase;

class PayoutResponseTest extends TestCase
{
    /**
     * @var PayoutRequest
     */
    protected $request;

    public function setUp()
    {
        parent::setUp();
        $this->request = new PayoutRequest($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('PayoutSuccess.txt');
        $response = new PayoutResponse($this->request, $httpResponse->getBody(true));

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isCancelled());
        $this->assertFalse($response->isPending());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('0', $response->getStatus());
        $this->assertNull($response->getCode());
        $this->assertNull($response->getMessage());
        $this->assertNull($response->getTransactionId());
        $this->assertSame(2990639, $response->getTransactionReference());
        $this->assertSame(2990639, $response->getCreditNumber());
    }

    public function testFailed()
    {
        $httpResponse = $this->getMockHttpResponse('PayoutFailed.txt');
        $response = new PayoutResponse($this->request, $httpResponse->getBody(true));
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isCancelled());
        $this->assertFalse($response->isPending());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('1', $response->getStatus());
        $this->assertSame(18011, $response->getCode());
        $this->assertSame('Order number is invalid.', $response->getMessage());
        $this->assertNull($response->getTransactionId());
        $this->assertNull($response->getTransactionReference());
        $this->assertNull($response->getCreditNumber());
        $this->assertNull($response->getTransactionId());
        $this->assertNull($response->getTransactionReference());
    }
}
