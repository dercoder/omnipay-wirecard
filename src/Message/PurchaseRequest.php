<?php

namespace Omnipay\Wirecard\Message;

use Omnipay\Wirecard\Support\Helper;

/**
 * Class PurchaseRequest
 * @package Omnipay\Wirecard\Message
 */
class PurchaseRequest extends AbstractRequest
{
    /**
     * @return string paymentType
     */
    public function getPaymentType()
    {
        if ($paymentType = $this->getParameter('paymentType')) {
            return $paymentType;
        }

        return 'SELECT';
    }

    /**
     * @param string $value paymentType
     *
     * @return $this
     */
    public function setPaymentType($value)
    {
        return $this->setParameter('paymentType', $value);
    }

    /**
     * @return string language
     */
    public function getLanguage()
    {
        return $this->getParameter('language');
    }

    /**
     * @param string $value $language
     *
     * @return $this
     */
    public function setLanguage($value)
    {
        return $this->setParameter('language', $value);
    }

    /**
     * @return string pendingUrl
     */
    public function getPendingUrl()
    {
        return $this->getParameter('pendingUrl');
    }

    /**
     * @param string $value pendingUrl
     *
     * @return $this
     */
    public function setPendingUrl($value)
    {
        return $this->setParameter('pendingUrl', $value);
    }

    /**
     * @return string serviceUrl
     */
    public function getServiceUrl()
    {
        return $this->getParameter('serviceUrl');
    }

    /**
     * @param string $value serviceUrl
     *
     * @return $this
     */
    public function setServiceUrl($value)
    {
        return $this->setParameter('serviceUrl', $value);
    }

    /**
     * @return string imageUrl
     */
    public function getImageUrl()
    {
        return $this->getParameter('imageUrl');
    }

    /**
     * @param string $value imageUrl
     *
     * @return $this
     */
    public function setImageUrl($value)
    {
        return $this->setParameter('imageUrl', $value);
    }

    /**
     * @return array
     */
    public function getData()
    {
        $this->validate(
            'customerId',
            'secret',
            'transactionId',
            'currency',
            'amount',
            'description',
            'language',
            'returnUrl',
            'cancelUrl',
            'notifyUrl',
            'pendingUrl',
            'serviceUrl'
        );

        $data = array(
            'omnipayTransactionId' => $this->getTransactionId(),
            'customerId'           => $this->getCustomerId(),
            'shopId'               => $this->getShopId(),
            'paymentType'          => $this->getPaymentType(),
            'currency'             => $this->getCurrency(),
            'orderDescription'     => $this->getDescription(),
            'orderReference'       => $this->getTransactionId(),
            'amount'               => $this->getAmount(),
            'successUrl'           => $this->getReturnUrl(),
            'failureUrl'           => $this->getCancelUrl(),
            'cancelUrl'            => $this->getCancelUrl(),
            'confirmUrl'           => $this->getNotifyUrl(),
            'pendingUrl'           => $this->getPendingUrl(),
            'serviceUrl'           => $this->getServiceUrl(),
            'language'             => $this->getLanguage()
        );

        /* Optional parameters should be added like this */
        if ($imageUrl = $this->getImageUrl()) {
            $data['imageUrl'] = $imageUrl;
        }

        $data['requestFingerprintOrder'] = Helper::getRequestFingerprintOrder($data);
        $data['requestFingerprint'] = Helper::getRequestFingerprint($data, $this->getSecret());

        return $data;
    }

    /**
     * @param mixed $data
     *
     * @return PurchaseResponse
     */
    public function sendData($data)
    {
        return new PurchaseResponse($this, $data);
    }
}
