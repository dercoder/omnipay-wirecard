<?php

namespace Omnipay\Wirecard\Message;

use Omnipay\Tests\TestCase;

class CompletePurchaseResponseTest extends TestCase
{
    public function testSuccess()
    {
        $request = new CompletePurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $response = new CompletePurchaseResponse($request, array(
            'omnipayTransactionId'     => 'TX12345',
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
            'responseFingerprint'      => '92f405bbf5708b602e93087e0f63a4f2'
        ));

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isPending());
        $this->assertFalse($response->isCancelled());
        $this->assertSame('SUCCESS', $response->getCode());
        $this->assertSame('TX12345', $response->getTransactionId());
        $this->assertSame('121588', $response->getTransactionReference());
        $this->assertSame('SUCCESS', $response->getPaymentState());
        $this->assertSame('GIROPAY', $response->getPaymentType());
        $this->assertSame('GIROPAY', $response->getFinancialInstitution());
        $this->assertSame('The checkout process has been successfully finished.', $response->getMessage());
    }

    public function testFailure()
    {
        $request = new CompletePurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $response = new CompletePurchaseResponse($request, array(
            'omnipayTransactionId' => 'TX12345',
            'consumerMessage'      => 'The transaction has not been authorised.',
            'message'              => 'The transaction has not been authorised.',
            'paymentState'         => 'FAILURE'
        ));

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isPending());
        $this->assertFalse($response->isCancelled());
        $this->assertSame('FAILURE', $response->getCode());
        $this->assertSame('TX12345', $response->getTransactionId());
        $this->assertNull($response->getTransactionReference());
        $this->assertSame('FAILURE', $response->getPaymentState());
        $this->assertNull($response->getPaymentType());
        $this->assertNull($response->getFinancialInstitution());
        $this->assertSame('An error occurred during the checkout process: The transaction has not been authorised.', $response->getMessage());
    }

    public function testCancel()
    {
        $request = new CompletePurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $response = new CompletePurchaseResponse($request, array(
            'omnipayTransactionId' => 'TX12345',
            'paymentState'         => 'CANCEL'
        ));

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isPending());
        $this->assertTrue($response->isCancelled());
        $this->assertSame('CANCEL', $response->getCode());
        $this->assertSame('TX12345', $response->getTransactionId());
        $this->assertNull($response->getTransactionReference());
        $this->assertSame('CANCEL', $response->getPaymentState());
        $this->assertNull($response->getPaymentType());
        $this->assertNull($response->getFinancialInstitution());
        $this->assertSame('The checkout process has been cancelled by the user.', $response->getMessage());
    }

    public function testPending()
    {
        $request = new CompletePurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $response = new CompletePurchaseResponse($request, array(
            'omnipayTransactionId'     => 'TX12345',
            'amount'                   => '5.00',
            'currency'                 => 'EUR',
            'paymentType'              => 'GIROPAY',
            'financialInstitution'     => 'GIROPAY',
            'language'                 => 'en',
            'orderNumber'              => '121588',
            'paymentState'             => 'PENDING',
            'gatewayReferenceNumber'   => 'DGW_121588_RN',
            'gatewayContractNumber'    => 'DemoContractNumber123',
            'avsResponseCode'          => 'X',
            'avsResponseMessage'       => 'Demo AVS ResultMessage',
            'avsProviderResultCode'    => 'X',
            'avsProviderResultMessage' => 'Demo AVS ProviderResultMessage',
            'responseFingerprintOrder' => 'amount,currency,paymentType,financialInstitution,language,orderNumber,paymentState,gatewayReferenceNumber,gatewayContractNumber,avsResponseCode,avsResponseMessage,avsProviderResultCode,avsProviderResultMessage,secret,responseFingerprintOrder',
            'responseFingerprint'      => '92f405bbf5708b602e93087e0f63a4f2'
        ));

        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isPending());
        $this->assertFalse($response->isCancelled());
        $this->assertSame('PENDING', $response->getCode());
        $this->assertSame('TX12345', $response->getTransactionId());
        $this->assertSame('121588', $response->getTransactionReference());
        $this->assertSame('PENDING', $response->getPaymentState());
        $this->assertSame('GIROPAY', $response->getPaymentType());
        $this->assertSame('GIROPAY', $response->getFinancialInstitution());
        $this->assertSame('The checkout process is pending and not yet finished.', $response->getMessage());
    }

    public function testUnknown()
    {
        $request = new CompletePurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $response = new CompletePurchaseResponse($request, array(
            'omnipayTransactionId' => 'TX12345',
            'paymentState'         => 'UNKNOWN'
        ));

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isPending());
        $this->assertFalse($response->isCancelled());
        $this->assertSame('UNKNOWN', $response->getCode());
        $this->assertSame('TX12345', $response->getTransactionId());
        $this->assertNull($response->getTransactionReference());
        $this->assertSame('UNKNOWN', $response->getPaymentState());
        $this->assertNull($response->getPaymentType());
        $this->assertNull($response->getFinancialInstitution());
        $this->assertSame('Error: The payment state "UNKNOWN" is not a valid state.', $response->getMessage());
    }
}