<?php

namespace Omnipay\Wirecard;

use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    /**
     * @var Gateway
     */
    public $gateway;

    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setCustomerId('D200001');
        $this->gateway->setShopId('3D');
        $this->gateway->setSecret('B8AKTPWBRMNBV455FG6M2DANE99WU2');
    }

    public function testPurchase()
    {
        $request = $this->gateway->purchase(array(
            'paymentType' => 'CCARD',
            'serviceUrl'  => 'https://www.example.com/terms.html'
        ));

        $this->assertSame('D200001', $request->getCustomerId());
        $this->assertSame('3D', $request->getShopId());
        $this->assertSame('B8AKTPWBRMNBV455FG6M2DANE99WU2', $request->getSecret());
        $this->assertSame('CCARD', $request->getPaymentType());
        $this->assertSame('https://www.example.com/terms.html', $request->getServiceUrl());
        $this->assertInstanceOf('Omnipay\Wirecard\Message\PurchaseRequest', $request);
    }

    public function testCompletePurchase()
    {
        $request = $this->gateway->completePurchase();
        $this->assertInstanceOf('Omnipay\Wirecard\Message\CompletePurchaseRequest', $request);
    }
}
