<?php

namespace Omnipay\Wirecard\Message;

use Omnipay\Common\Message\AbstractResponse;

class CompletePurchaseResponse extends AbstractResponse
{
    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->getPaymentState() == 'SUCCESS' ? true : false;
    }

    /**
     * @return bool
     */
    public function isPending()
    {
        return $this->getPaymentState() == 'PENDING' ? true : false;
    }

    /**
     * @return bool
     */
    public function isCancelled()
    {
        return $this->getPaymentState() == 'CANCEL' ? true : false;
    }

    /**
     * @return string
     */
    public function getTransactionReference()
    {
        return isset($this->data['orderNumber']) ? $this->data['orderNumber'] : null;
    }

    /**
     * @return string
     */
    public function getPaymentState()
    {
        return isset($this->data['paymentState']) ? $this->data['paymentState'] : null;
    }

    /**
     * @return string
     */
    public function getPaymentType()
    {
        return isset($this->data['paymentType']) ? $this->data['paymentType'] : null;
    }

    /**
     * @return string
     */
    public function getFinancialInstitution()
    {
        return isset($this->data['financialInstitution']) ? $this->data['financialInstitution'] : null;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        switch ($this->getPaymentState()) {
            case 'FAILURE':
                $errorMessage = isset($this->data['message']) ? $this->data['message'] : 'Unknown';
                $message = 'An error occurred during the checkout process: ' . $errorMessage;
                // NOTE: please log this error message in a persistent manner for later use
                break;
            case 'CANCEL':
                $message = 'The checkout process has been cancelled by the user.';
                break;
            case 'PENDING':
                $message = 'The checkout process is pending and not yet finished.';
                break;
            case 'SUCCESS':
                $message = 'The checkout process has been successfully finished.';
                break;
            default:
                $message = 'Error: The payment state "' . $this->getPaymentState() . '" is not a valid state.';
                break;
        }

        return $message;
    }
}
