<?php

namespace Omnipay\Wirecard\Message;

use Omnipay\Tests\TestCase;

class PayoutRequestTest extends TestCase
{
    /**
     * @var PayoutRequest
     */
    private $request;

    public function setUp()
    {
        parent::setUp();
        $this->request = new PayoutRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(array(
            'customerId'           => 'D200001',
            'shopId'               => '3D',
            'secret'               => 'B8AKTPWBRMNBV455FG6M2DANE99WU2',
            'toolkitPassword'      => 'jcv45z',
            'amount'               => 5.00,
            'currency'             => 'EUR',
            'transactionReference' => '123456',
            'language'             => 'XX'
        ));
    }

    public function testGetData()
    {
        $data = $this->request->getData();
        $this->assertSame('D200001', $data['customerId']);
        $this->assertSame('3D', $data['shopId']);
        $this->assertSame('jcv45z', $data['toolkitPassword']);
        $this->assertSame('5.00', $data['amount']);
        $this->assertSame('refund', $data['command']);
        $this->assertSame('EUR', $data['currency']);
        $this->assertSame('EN', $data['language']);
        $this->assertSame('123456', $data['orderNumber']);
        $this->request->setLanguage('DE');
        $data = $this->request->getData();
        $this->assertSame('DE', $data['language']);
        $this->assertSame('customerId,shopId,toolkitPassword,command,language,orderNumber,amount,currency,requestFingerprint', implode(',', array_keys($data)));
    }

    public function testSendData()
    {
        $this->setMockHttpResponse('PayoutSuccess.txt');
        $data = $this->request->getData();
        $response = $this->request->sendData($data);
        $this->assertInstanceOf('Omnipay\Wirecard\Message\PayoutResponse', $response);
    }
}
