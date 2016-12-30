<?php

namespace Omnipay\Wirecard\Message;

use Omnipay\Wirecard\Support\Helper;
use Omnipay\Common\Exception\InvalidRequestException;

class CompletePurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $data = $this->httpRequest->request->all();

        if (!Helper::areReturnParametersValid($data, $this->getSecret())) {
            throw new InvalidRequestException('The verification of the returned data was not successful.');
        }

        return $data;
    }

    public function sendData($data)
    {
        return new CompletePurchaseResponse($this, $data);
    }
}
