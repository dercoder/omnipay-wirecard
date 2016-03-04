<?php

namespace Omnipay\Wirecard\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Wirecard\Support\Helper;

class CheckoutCompletePurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    protected $secret;

    public function __construct(RequestInterface $request, $data, $secret)
    {
        parent::__construct($request, $data);
        $this->secret = $secret;
    }

    public function isSuccessful()
    {
        return ($this->data['paymentState'] == 'SUCCESS') ? true : false;
    }

    public function isPending()
    {
        return ($this->data['paymentState'] == 'PENDING') ? true : false;
    }

    public function isCancelled()
    {
        return ($this->data['paymentState'] == 'CANCEL') ? true : false;
    }

    public function isRedirect()
    {
        return false;
    }

    public function getRedirectUrl()
    {
        return null;
    }

    public function getRedirectMethod()
    {
        return null;
    }

    public function getRedirectData()
    {
        return null;
    }

    public function getMessage()
    {
        return Helper::handleCheckoutResult($this->data, $this->secret);
    }
}
