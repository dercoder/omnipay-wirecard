<?php

namespace Omnipay\Wirecard\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

/**
 * Class PayoutResponse
 * @package Omnipay\Wirecard\Message
 */
class PayoutResponse extends AbstractResponse
{
    /**
     * PayoutResponse constructor.
     *
     * @param RequestInterface $request
     * @param string           $data
     */
    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, []);
        foreach (explode('&', $data) as $keyValue) {
            $param = explode('=', $keyValue);
            if (sizeof($param) == 2) {
                $key = urldecode($param[0]);
                $value = urldecode($param[1]);
                $this->data[$key] = $value;
            }
        }
    }

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->getStatus() === '0';
    }

    /**
     * @return int|null
     */
    public function getTransactionReference()
    {
        return $this->getCreditNumber();
    }

    /**
     * @return string|null
     */
    public function getStatus()
    {
        return isset($this->data['status']) ? $this->data['status'] : null;
    }

    /**
     * @return int|null
     */
    public function getCode()
    {
        return isset($this->data['errorCode']) ? (int) $this->data['errorCode'] : null;
    }

    /**
     * @return string|null
     */
    public function getMessage()
    {
        return isset($this->data['message']) ? $this->data['message'] : null;
    }

    /**
     * @return int|null
     */
    public function getCreditNumber()
    {
        return isset($this->data['creditNumber']) ? (int) $this->data['creditNumber'] : null;
    }
}
