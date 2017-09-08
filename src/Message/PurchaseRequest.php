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
     * @return string displayText
     */
    public function getDisplayText()
    {
        return $this->getParameter('displayText');
    }

    /**
     * @param string $value displayText
     *
     * @return $this
     */
    public function setDisplayText($value)
    {
        return $this->setParameter('displayText', $value);
    }

    /**
     * @return string backgroundColor
     */
    public function getBackgroundColor()
    {
        return $this->getParameter('backgroundColor');
    }

    /**
     * @param string $value backgroundColor
     *
     * @return $this
     */
    public function setBackgroundColor($value)
    {
        return $this->setParameter('backgroundColor', strtolower($value));
    }

    /**
     * @return bool autoDeposit
     */
    public function getAutoDeposit()
    {
        return $this->getParameter('autoDeposit');
    }

    /**
     * @param bool $value autoDeposit
     *
     * @return $this
     */
    public function setAutoDeposit($value)
    {
        return $this->setParameter('autoDeposit', (bool) $value);
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

        if ($displayText = $this->getDisplayText()) {
            $data['displayText'] = $displayText;
        }

        if ($backgroundColor = $this->getBackgroundColor()) {
            $data['backgroundColor'] = $backgroundColor;
        }

        switch ($this->getAutoDeposit()) {
            case true:
                $data['autoDeposit'] = 'yes';
                break;
            case false:
                $data['autoDeposit'] = 'no';
                break;
        }

        $data['requestFingerprintOrder'] = Helper::getRequestFingerprintOrder($data);
        $data['requestFingerprint'] = Helper::getPurchaseRequestFingerprint($data, $this->getSecret());

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
