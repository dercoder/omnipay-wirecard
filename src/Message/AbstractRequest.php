<?php

namespace Omnipay\Wirecard\Message;

/**
 * Class AbstractRequest
 * @package Omnipay\Wirecard\Message
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
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
}
