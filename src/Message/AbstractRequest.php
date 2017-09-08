<?php

namespace Omnipay\Wirecard\Message;

/**
 * Class AbstractRequest
 * @package Omnipay\Wirecard\Message
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    /**
     * https://guides.wirecard.at/request_parameters#language
     * @var array
     */
    public $languages = array(
        'AR', 'BS', 'BG', 'ZH', 'HR',
        'CS', 'DA', 'NL', 'EN', 'ET',
        'FI', 'FR', 'DE', 'EL', 'HE',
        'HI', 'HU', 'IT', 'JA', 'KO',
        'LV', 'LT', 'MK', 'NO', 'PL',
        'PT', 'RO', 'RU', 'SR', 'SK',
        'SL', 'ES', 'SV', 'TR', 'UK'
    );

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
     * Get Wirecard toolkit password.
     *
     * @return string toolkitPassword
     */
    public function getToolkitPassword()
    {
        return $this->getParameter('toolkitPassword');
    }

    /**
     * Set Wirecard toolkit password.
     *
     * @param string $value toolkitPassword
     *
     * @return $this
     */
    public function setToolkitPassword($value)
    {
        return $this->setParameter('toolkitPassword', $value);
    }

    /**
     * @return string language
     */
    public function getLanguage()
    {
        if ($language = $this->getParameter('language')) {
            $language = strtoupper($language);
            if (in_array($language, $this->languages)) {
                return $language;
            }
        }

        return 'EN';
    }

    /**
     * @param string $value $language
     *
     * @return $this
     */
    public function setLanguage($value)
    {
        return $this->setParameter('language', $value);
    }
}
