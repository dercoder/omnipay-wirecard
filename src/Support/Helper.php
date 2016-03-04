<?php

namespace Omnipay\Wirecard\Support;

class Helper {

    /**
     * Returns the value for the request parameter "requestFingerprintOrder".
     * @param  array $parameters
     * @return string
     */
    public static function getRequestFingerprintOrder($parameters)
    {
        $fingerprint = "";
        foreach ($parameters as $key => $value) {
            $fingerprint .= "$key,";
        }
        $fingerprint .= "requestFingerprintOrder,secret";

        return $fingerprint;
    }

    /**
     * Returns the value for the request parameter "requestFingerprint".
     * @param  array $parameters
     * @param  string $secret_key
     * @return string
     */
    public static function getRequestFingerprint($parameters, $secret_key)
    {
        $fingerprint = "";
        foreach ($parameters as $key=>$value) {
            $fingerprint .= "$value";
        }
        $fingerprint .= "$secret_key";

        return md5($fingerprint);
    }

    /**
     * Checks if response parameters are valid by computing and comparing the fingerprints.
     * @param  array $parameters
     * @param  string $secret_key
     * @return boolean
     */
    public static function areReturnParametersValid($parameters, $secret_key)
    {

        // gets the fingerprint-specific response parameters sent by Wirecard
        $responseFingerprintOrder = isset($parameters["responseFingerprintOrder"]) ? $parameters["responseFingerprintOrder"] : "";
        $responseFingerprint = isset($parameters["responseFingerprint"]) ? $parameters["responseFingerprint"] : "";

        // values of the response parameters for computing the fingerprint
        $fingerprintSeed = "";

        // array containing the names of the response parameters used by Wirecard to compute the response fingerprint
        $order = explode(",", $responseFingerprintOrder);

        // checks if there are required response parameters in responseFingerprintOrder
        if (in_array("paymentState", $order) && in_array("secret", $order)) {
            // collects all values of response parameters used for computing the fingerprint
            for ($i = 0; $i < count($order); $i++) {
                $name = $order[$i];
                $value = isset($parameters[$name]) ? $parameters[$name] : "";
                $fingerprintSeed .= $value; // adds value of response parameter to fingerprint
                if (strcmp($name, "secret") == 0) {
                    $fingerprintSeed .= $secret_key; // adds your secret to fingerprint
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

    /**
     * Checks the result of the payment state and returns an appropiate text message.
     * @param  array $parameters
     * @param  string $secret_key
     * @return string
     */
    public static function handleCheckoutResult($parameters, $secret_key)
    {
        $paymentState = isset($parameters["paymentState"]) ? $parameters["paymentState"] : "";

        switch ($paymentState) {
            case "FAILURE":
                $error_message = isset($parameters["message"]) ? $parameters["message"] : "";
                $message = "An error occured during the checkout process: " . $error_message;
                // NOTE: please log this error message in a persistent manner for later use
                break;
            case "CANCEL":
                $message = "The checkout process has been cancelled by the user.";
                break;
            case "PENDING":
                if (self::areReturnParametersValid($parameters, $secret_key)) {
                    $message = "The checkout process is pending and not yet finished.";
                    // NOTE: please store all related information regarding the transaction in a persistant manner for later use
                } else {
                    $message = "The verification of the returned data was not successful. Maybe an invalid request to this page or a wrong secret?";
                }
                break;
            case "SUCCESS":
                if (self::areReturnParametersValid($parameters, $secret_key)) {
                    $message = "The checkout process has been successfully finished.";
                    // NOTE: please store all related information regarding the transaction in a persistant manner for later use
                } else {
                    $message = "The verification of the returned data was not successful. Maybe an invalid request to this page or a wrong secret?";
                }
                break;
            default:
                $message = "Error: The payment state $paymentState is not a valid state.";
                break;
        }

        return $message;
    }

}