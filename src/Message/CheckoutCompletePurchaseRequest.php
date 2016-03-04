<?php

namespace Omnipay\Wirecard\Message;

class CheckoutCompletePurchaseRequest extends AbstractRequest
{
    public function getSecret()
    {
        return $this->getParameter('secret');
    }

    public function setSecret($value)
    {
        return $this->setParameter('secret', $value);
    }

    public function getData()
    {
        $data = $this->httpRequest->request->all();

        return $data;
    }

    public function sendData($data)
    {
        return $this->response = new CheckoutCompletePurchaseResponse($this, $data, $this->getSecret());
    }
}
