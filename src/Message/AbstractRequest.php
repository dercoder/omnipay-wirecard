<?php

namespace Omnipay\Wirecard\Message;

use Omnipay\Common\Message\AbstractRequest as OmnipayRequest;

abstract class AbstractRequest extends OmnipayRequest
{
    protected $liveEndpoint = 'https://checkout.wirecard.com/page/init.php';
    protected $testEndpoint = 'https://checkout.wirecard.com/page/init.php';

    protected function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }
}
