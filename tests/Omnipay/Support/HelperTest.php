<?php

namespace Omnipay\Wirecard\Support;

use Omnipay\Tests\TestCase;

class HelperTest extends TestCase
{
    public function testGetRequestFingerprintOrder()
    {
        $fingerprintOrder = Helper::getRequestFingerprintOrder(array(
            'customerId'       => 'D200001',
            'shopId'           => '3D',
            'paymentType'      => 'CCARD',
            'currency'         => 'EUR',
            'orderDescription' => 'Test',
            'orderReference'   => 'TX1234',
            'amount'           => 32.43,
            'successUrl'       => 'https://www.example.com/success.html',
            'failureUrl'       => 'https://www.example.com/failure.html',
            'cancelUrl'        => 'https://www.example.com/cancel.html',
            'confirmUrl'       => 'https://www.example.com/confirm.html',
            'pendingUrl'       => 'https://www.example.com/pending.html',
            'serviceUrl'       => 'https://www.example.com/service.html',
            'imageUrl'         => 'https://www.example.com/image.png',
            'language'         => 'EN'
        ));

        $this->assertSame('customerId,shopId,paymentType,currency,orderDescription,orderReference,amount,successUrl,failureUrl,cancelUrl,confirmUrl,pendingUrl,serviceUrl,imageUrl,language,requestFingerprintOrder,secret', $fingerprintOrder);
    }

    public function testGetPurchaseRequestFingerprint()
    {
        $fingerprint = Helper::getPurchaseRequestFingerprint(array(
            'customerId'       => 'D200001',
            'shopId'           => '3D',
            'paymentType'      => 'CCARD',
            'currency'         => 'EUR',
            'orderDescription' => 'Test',
            'orderReference'   => 'TX1234',
            'amount'           => 32.43,
            'successUrl'       => 'https://www.example.com/success.html',
            'failureUrl'       => 'https://www.example.com/failure.html',
            'cancelUrl'        => 'https://www.example.com/cancel.html',
            'confirmUrl'       => 'https://www.example.com/confirm.html',
            'pendingUrl'       => 'https://www.example.com/pending.html',
            'serviceUrl'       => 'https://www.example.com/service.html',
            'imageUrl'         => 'https://www.example.com/image.png',
            'language'         => 'EN'
        ), 'B8AKTPWBRMNBV455FG6M2DANE99WU2');

        $this->assertSame('46b0e2c94338f49dc396f6e46bfcc8e2', $fingerprint);
    }

    public function testGetPayoutRequestFingerprint()
    {
        $fingerprint = Helper::getPayoutRequestFingerprint(array(
            'customerId'      => 'D200001',
            'shopId'          => '3D',
            'toolkitPassword' => 'jcv45z',
            'secret'          => 'B8AKTPWBRMNBV455FG6M2DANE99WU2',
            'command'         => 'refund',
            'language'        => 'EN',
            'orderNumber'     => 12345,
            'amount'          => 32.43,
            'currency'        => 'EUR'
        ), 'B8AKTPWBRMNBV455FG6M2DANE99WU2');

        $this->assertSame('bfde5317ebfcd38ffe727bb568b9e8703e5cd418cab631ed9299a844fe9aca8c594da57e2fec0eb233203f0081c46ae4973082a03bfeacdd50d8b1fd7e814889', $fingerprint);
    }

    public function testAreReturnParametersValid()
    {
        $parameters1 = array(
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
        );

        $parameters2 = array(
            'amount'                   => '5.00',
            'currency'                 => 'EUR',
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
        );

        $parameters3 = array(
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
            'avsProviderResultMessage' => 'Demo AVS ProviderResultMessage'
        );

        $this->assertTrue(Helper::areReturnParametersValid($parameters1, 'B8AKTPWBRMNBV455FG6M2DANE99WU2'));
        $this->assertFalse(Helper::areReturnParametersValid($parameters2, 'B8AKTPWBRMNBV455FG6M2DANE99WU2'));
        $this->assertFalse(Helper::areReturnParametersValid($parameters3, 'B8AKTPWBRMNBV455FG6M2DANE99WU2'));
        $this->assertFalse(Helper::areReturnParametersValid(array(), 'B8AKTPWBRMNBV455FG6M2DANE99WU2'));
    }
}