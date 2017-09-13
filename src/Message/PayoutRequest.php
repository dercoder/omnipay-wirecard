<?php

namespace Omnipay\Wirecard\Message;

use Omnipay\Wirecard\Support\Helper;

/**
 * Class PayoutRequest
 * @package Omnipay\Wirecard\Message
 */
class PayoutRequest extends AbstractRequest
{
    /**
     * @var string
     */
    protected $endpoint = 'https://checkout.wirecard.com/page/toolkit.php';

    /**
     * @return array
     */
    public function getData()
    {
        $this->validate(
            'customerId',
            'secret',
            'toolkitPassword',
            'transactionReference',
            'currency',
            'amount'
        );

        $data = array(
            'customerId'      => $this->getCustomerId(),
            'shopId'          => $this->getShopId(),
            'toolkitPassword' => $this->getToolkitPassword(),
            'secret'          => $this->getSecret(),
            'command'         => 'refund',
            'language'        => $this->getLanguage(),
            'orderNumber'     => $this->getTransactionReference(),
            'amount'          => $this->getAmount(),
            'currency'        => $this->getCurrency()
        );

        $data['requestFingerprint'] = Helper::getPayoutRequestFingerprint($data, $this->getSecret());
        unset($data['secret']);

        return $data;
    }

    public function sendData($data)
    {
        $httpResponse = $this->httpClient->post($this->endpoint, null, $data)->send();
        return new PayoutResponse($this, $httpResponse->getBody(true));
    }
}
