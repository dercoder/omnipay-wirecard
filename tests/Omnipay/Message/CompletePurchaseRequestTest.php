<?php

namespace Omnipay\Wirecard\Message;

use Omnipay\Tests\TestCase;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class CompletePurchaseRequestTest extends TestCase
{
    /**
     * @var CompletePurchaseRequest
     */
    private $request;

    public function setUp()
    {
        parent::setUp();

        $httpRequest = new HttpRequest(array(), array(
            'amount'                   => '5.00',
            'currency'                 => 'EUR',
            'paymentType'              => 'GIROPAY',
            'financialInstitution'     => 'GIROPAY',
            'language'                 => 'en',
            'orderNumber'              => '121588',
            'paymentState'             => 'SUCCESS',
            'gatewayReferenceNumber'   => 'DGW_121588_RN',
            'gatewayContractNumber'    => 'DemoContractNumber123',
            'avsResponseCode'          => 'X',
            'avsResponseMessage'       => 'Demo AVS ResultMessage',
            'avsProviderResultCode'    => 'X',
            'avsProviderResultMessage' => 'Demo AVS ProviderResultMessage',
            'responseFingerprintOrder' => 'amount,currency,paymentType,financialInstitution,language,orderNumber,paymentState,gatewayReferenceNumber,gatewayContractNumber,avsResponseCode,avsResponseMessage,avsProviderResultCode,avsProviderResultMessage,secret,responseFingerprintOrder',
            'responseFingerprint'      => '92f405bbf5708b602e93087e0f63a4f2',
        ));

        $this->request = new CompletePurchaseRequest($this->getHttpClient(), $httpRequest);
        $this->request->initialize(array(
            'customerId' => 'D200001',
            'shopId'     => '3D',
            'secret'     => 'B8AKTPWBRMNBV455FG6M2DANE99WU2'
        ));
    }

    public function testGetData()
    {
        $data = $this->request->getData();
        $this->assertSame(array(
            'amount'                   => '5.00',
            'currency'                 => 'EUR',
            'paymentType'              => 'GIROPAY',
            'financialInstitution'     => 'GIROPAY',
            'language'                 => 'en',
            'orderNumber'              => '121588',
            'paymentState'             => 'SUCCESS',
            'gatewayReferenceNumber'   => 'DGW_121588_RN',
            'gatewayContractNumber'    => 'DemoContractNumber123',
            'avsResponseCode'          => 'X',
            'avsResponseMessage'       => 'Demo AVS ResultMessage',
            'avsProviderResultCode'    => 'X',
            'avsProviderResultMessage' => 'Demo AVS ProviderResultMessage',
            'responseFingerprintOrder' => 'amount,currency,paymentType,financialInstitution,language,orderNumber,paymentState,gatewayReferenceNumber,gatewayContractNumber,avsResponseCode,avsResponseMessage,avsProviderResultCode,avsProviderResultMessage,secret,responseFingerprintOrder',
            'responseFingerprint'      => '92f405bbf5708b602e93087e0f63a4f2',
        ), $data);

        $this->request->setSecret('1234');
        $this->setExpectedException('Omnipay\Common\Exception\InvalidRequestException', 'The verification of the returned data was not successful.');
        $this->request->getData();
    }

    public function testSendData()
    {
        $data = $this->request->getData();
        $response = $this->request->sendData($data);
        $this->assertInstanceOf('Omnipay\Wirecard\Message\CompletePurchaseResponse', $response);
    }
}