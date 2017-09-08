<?php

namespace Omnipay\Wirecard\Support;

/**
 * Class Helper
 * @package Omnipay\Wirecard\Support
 */
class Helper
{
    /**
     * Returns the value for the request parameter 'requestFingerprintOrder'.
     *
     * @param  array $parameters
     *
     * @return string
     */
    public static function getRequestFingerprintOrder($parameters)
    {
        $fingerprint = implode(',', array_keys($parameters));
        $fingerprint .= ',requestFingerprintOrder,secret';

        return $fingerprint;
    }

    /**
     * Returns the value for the request parameter 'requestFingerprint' for purchase.
     *
     * @param  array  $parameters
     * @param  string $secretKey
     *
     * @return string
     */
    public static function getPurchaseRequestFingerprint($parameters, $secretKey)
    {
        $fingerprint = implode('', $parameters);
        $fingerprint .= $secretKey;

        return md5($fingerprint);
    }

    /**
     * Returns the value for the request parameter 'requestFingerprint' for payout.
     *
     * @param  array  $parameters
     * @param  string $secretKey
     *
     * @return string
     */
    public static function getPayoutRequestFingerprint($parameters, $secretKey)
    {
        $fingerprint = implode('', $parameters);
        return hash_hmac('sha512', $fingerprint, $secretKey);
    }

    /**
     * Checks if response parameters are valid by computing and comparing the fingerprints.
     *
     * @param  array  $parameters
     * @param  string $secretKey
     *
     * @return boolean
     */
    public static function areReturnParametersValid($parameters, $secretKey)
    {
        // gets the fingerprint-specific response parameters sent by Wirecard
        if (!isset($parameters['responseFingerprintOrder']) or !isset($parameters['responseFingerprint'])) {
            return false;
        }

        $responseFingerprintOrder = $parameters['responseFingerprintOrder'];
        $responseFingerprint = $parameters['responseFingerprint'];

        // values of the response parameters for computing the fingerprint
        $fingerprintSeed = '';

        // array containing the names of the response parameters used by Wirecard to compute the response fingerprint
        $order = explode(',', $responseFingerprintOrder);

        // checks if there are required response parameters in responseFingerprintOrder
        if (in_array('paymentState', $order) && in_array('secret', $order)) {
            // collects all values of response parameters used for computing the fingerprint
            for ($i = 0; $i < count($order); $i++) {
                $name = $order[$i];
                $value = isset($parameters[$name]) ? $parameters[$name] : '';
                $fingerprintSeed .= $value; // adds value of response parameter to fingerprint
                if (strcmp($name, 'secret') == 0) {
                    $fingerprintSeed .= $secretKey; // adds your secret to fingerprint
                }
            }

            $fingerprint = md5($fingerprintSeed); // computes the fingerprint
            // checks if computed fingerprint and responseFingerprint have the same value
            if (strcmp($fingerprint, $responseFingerprint) == 0) {
                return true; // fingerprint check passed successfully
            }
        }

        return false;
    }
}
