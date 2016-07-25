<?php

namespace Omnipay\Wirecard\Message;

use Omnipay\Wirecard\Support\Helper;

class CheckoutPurchaseRequest extends AbstractRequest
{
    public function getSecret()
    {
        return $this->getParameter('secret');
    }

    public function setSecret($value)
    {
        return $this->setParameter('secret', $value);
    }

    public function getCustomerId()
    {
        return $this->getParameter('customerId');
    }

    public function setCustomerId($value)
    {
        return $this->setParameter('customerId', $value);
    }

    public function getShopId()
    {
        return $this->getParameter('shopId');
    }

    public function setShopId($value)
    {
        return $this->setParameter('shopId', $value);
    }

    public function getPaymentType()
    {
        return $this->getParameter('paymentType');
    }

    public function setPaymentType($value)
    {
        return $this->setParameter('paymentType', $value);
    }

    public function getLanguage()
    {
        return $this->getParameter('language');
    }

    public function setLanguage($value)
    {
        return $this->setParameter('language', $value);
    }

    public function getSuccessUrl()
    {
        return $this->getParameter('successUrl');
    }

    public function setSuccessUrl($value)
    {
        return $this->setParameter('successUrl', $value);
    }

    public function getFailureUrl()
    {
        return $this->getParameter('failureUrl');
    }

    public function setFailureUrl($value)
    {
        return $this->setParameter('failureUrl', $value);
    }

    public function getServiceUrl()
    {
        return $this->getParameter('serviceUrl');
    }

    public function setServiceUrl($value)
    {
        return $this->setParameter('serviceUrl', $value);
    }

    public function getCancelUrl()
    {
        return $this->getParameter('cancelUrl');
    }

    public function setCancelUrl($value)
    {
        return $this->setParameter('cancelUrl', $value);
    }

    public function getConfirmUrl()
    {
        return $this->getParameter('confirmUrl');
    }

    public function setConfirmUrl($value)
    {
        return $this->setParameter('confirmUrl', $value);
    }

    public function getImageUrl()
    {
        return $this->getParameter('imageUrl');
    }

    public function setImageUrl($value)
    {
        return $this->setParameter('imageUrl', $value);
    }

    public function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    public function getData()
    {
        $this->validate('customerId', 'amount', 'successUrl', 'cancelUrl');

        $data['customerId'] = $this->getCustomerId();
        $data['shopId'] = $this->getShopId();
        $data['paymentType'] = $this->getPaymentType();
        $data['currency'] = $this->getCurrency();
        $data['orderDescription'] = $this->getDescription();
        $data['orderReference'] = $this->getTransactionId();
        $data['amount'] = $this->getAmount();
        $data['successUrl'] = $this->getSuccessUrl();
        $data['failureUrl'] = $this->getFailureUrl();
        $data['cancelUrl'] = $this->getCancelUrl();
        $data['confirmUrl'] = $this->getConfirmUrl();
        $data['serviceUrl'] = $this->getServiceUrl();
        $data['imageUrl'] = $this->getImageUrl();
        $data['language'] = $this->getLanguage();
        $data['requestFingerprintOrder'] = Helper::getRequestFingerprintOrder($data);
        $data['requestFingerprint'] = Helper::getRequestFingerprint($data, $this->getSecret());

        return $data;
    }

    public function sendData($data)
    {
        return $this->response = new CheckoutPurchaseResponse($this, $data, $this->getEndpoint());
    }
}
