<?php

namespace Omnipay\Wirecard;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Wirecard\Message\PurchaseRequest;
use Omnipay\Wirecard\Message\CompletePurchaseRequest;

class Gateway extends AbstractGateway
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Wirecard';
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return array(
            'customerId' => '',
            'shopId'     => '',
            'secret'     => '',
            'testMode'   => false
        );
    }

    /**
     * Get Wirecard customer ID.
     *
     * @return string customerId
     */
    public function getCustomerId()
    {
        return $this->getParameter('customerId');
    }

    /**
     * Set Wirecard customer ID.
     *
     * @param string $value customerId
     *
     * @return $this
     */
    public function setCustomerId($value)
    {
        return $this->setParameter('customerId', $value);
    }

    /**
     * Get Wirecard shop ID.
     *
     * @return string shopId
     */
    public function getShopId()
    {
        return $this->getParameter('shopId');
    }

    /**
     * Set Wirecard shop ID.
     *
     * @param string $value shopId
     *
     * @return $this
     */
    public function setShopId($value)
    {
        return $this->setParameter('shopId', $value);
    }

    /**
     * Get Wirecard secret.
     *
     * @return string secret
     */
    public function getSecret()
    {
        return $this->getParameter('secret');
    }

    /**
     * Set Wirecard secret.
     *
     * @param string $value secret
     *
     * @return $this
     */
    public function setSecret($value)
    {
        return $this->setParameter('secret', $value);
    }

    /**
     * @param array $parameters
     *
     * @return AbstractRequest|PurchaseRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Wirecard\Message\PurchaseRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return AbstractRequest|CompletePurchaseRequest
     */
    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Wirecard\Message\CompletePurchaseRequest', $parameters);
    }
}
