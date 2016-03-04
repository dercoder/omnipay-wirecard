<?php

namespace Omnipay\Wirecard;

use Omnipay\Common\AbstractGateway;

/**
 * Checkout Page Class
 */
class CheckoutGateway extends AbstractGateway
{
    public function getName()
    {
        return 'Wirecard Checkout';
    }

    public function getSecret()
    {
        return $this->getParameter('SECRET');
    }

    public function setSecret($value)
    {
        return $this->setParameter('SECRET', $value);
    }

    public function getCustomerId()
    {
        return $this->getParameter('CUSTOMERID');
    }

    public function setCustomerId($value)
    {
        return $this->setParameter('CUSTOMERID', $value);
    }

    public function getDefaultParameters()
    {
        return array(
            'customerID' => '',
            'secret' => '',
        );
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Wirecard\Message\CheckoutPurchaseRequest', $parameters);
    }

    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Wirecard\Message\CheckoutCompletePurchaseRequest', $parameters);
    }
}
