<?php

namespace Omnipay\Wirecard\Message;

use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    /**
     * @var PurchaseRequest
     */
    private $request;

    public function setUp()
    {
        parent::setUp();
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(array(
            'customerId'      => 'D200001',
            'shopId'          => '3D',
            'secret'          => 'B8AKTPWBRMNBV455FG6M2DANE99WU2',
            'amount'          => 5.00,
            'currency'        => 'EUR',
            'transactionId'   => 'TX12345',
            'language'        => 'XX',
            'description'     => 'Test',
            'returnUrl'       => 'https://www.example.com/return.html',
            'cancelUrl'       => 'https://www.example.com/cancel.html',
            'notifyUrl'       => 'https://www.example.com/notify.html',
            'pendingUrl'      => 'https://www.example.com/pending.html',
            'serviceUrl'      => 'https://www.example.com/service.html',
            'imageUrl'        => 'https://www.example.com/image.png',
            'displayText'     => 'Hello World!',
            'backgroundColor' => 'FF00FF',
            'autoDeposit'     => true
        ));
    }

    public function testGetData()
    {
        $data = $this->request->getData();
        $this->assertSame('D200001', $data['customerId']);
        $this->assertSame('3D', $data['shopId']);
        $this->assertSame('SELECT', $data['paymentType']);
        $this->assertSame('5.00', $data['amount']);
        $this->assertSame('EUR', $data['currency']);
        $this->assertSame('Test', $data['orderDescription']);
        $this->assertSame('TX12345', $data['omnipayTransactionId']);
        $this->assertSame('TX12345', $data['orderReference']);
        $this->assertSame('EN', $data['language']);
        $this->assertSame('https://www.example.com/return.html', $data['successUrl']);
        $this->assertSame('https://www.example.com/cancel.html', $data['cancelUrl']);
        $this->assertSame('https://www.example.com/cancel.html', $data['failureUrl']);
        $this->assertSame('https://www.example.com/notify.html', $data['confirmUrl']);
        $this->assertSame('https://www.example.com/pending.html', $data['pendingUrl']);
        $this->assertSame('https://www.example.com/service.html', $data['serviceUrl']);
        $this->assertSame('https://www.example.com/image.png', $data['imageUrl']);
        $this->assertSame('Hello World!', $data['displayText']);
        $this->assertSame('ff00ff', $data['backgroundColor']);
        $this->assertSame('yes', $data['autoDeposit']);
        $this->request->setLanguage('DE');
        $this->request->setAutoDeposit(false);
        $data = $this->request->getData();
        $this->assertSame('DE', $data['language']);
        $this->assertSame('no', $data['autoDeposit']);
    }

    public function testSendData()
    {
        $data = $this->request->getData();
        $response = $this->request->sendData($data);
        $this->assertInstanceOf('Omnipay\Wirecard\Message\PurchaseResponse', $response);
    }
}
