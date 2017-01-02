# Omnipay: Wirecard

**Wirecard driver for the Omnipay PHP payment processing library**

[![Build Status](https://travis-ci.org/dercoder/omnipay-wirecard.svg?branch=master)](https://travis-ci.org/dercoder/omnipay-wirecard)
[![Coverage Status](https://coveralls.io/repos/dercoder/omnipay-wirecard/badge.svg?branch=master&service=github)](https://coveralls.io/github/dercoder/omnipay-wirecard?branch=master)

[![Latest Stable Version](https://poser.pugx.org/dercoder/omnipay-wirecard/v/stable.png)](https://packagist.org/packages/dercoder/omnipay-wirecard)
[![Total Downloads](https://poser.pugx.org/dercoder/omnipay-wirecard/downloads.png)](https://packagist.org/packages/dercoder/omnipay-wirecard)
[![Latest Unstable Version](https://poser.pugx.org/dercoder/omnipay-wirecard/v/unstable.png)](https://packagist.org/packages/dercoder/omnipay-wirecard)
[![License](https://poser.pugx.org/dercoder/omnipay-wirecard/license.png)](https://packagist.org/packages/dercoder/omnipay-wirecard)

[Omnipay](https://github.com/omnipay/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 5.3+. This package implements [Wirecard](https://www.wirecard.at) support for Omnipay.

> This library **only supports** Wirecard Checkout Page payment yet. You can [read more about](https://www.wirecard.at/en/solutions/products/checkout-page/) the Checkout Page solution here.

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply add it
to your `composer.json` file:

```json
{
    "require": {
        "dercoder/omnipay-wirecard": "~1.0"
    }
}
```

It will also install the Omnipay package if it's not available in the autoload.

## Basic usage

The following gateways are provided by this package:

* Wirecard (Wirecard Checkout Page)

For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay)
repository.

Firstly create the gateway:

```php
$gateway = Omnipay\Omnipay::create('Wirecard');
$gateway->setCustomerId('D200001'); // this is a valid demo customer id
$gateway->setShopId('3D'); // this is optional
$gateway->setSecret('B8AKTPWBRMNBV455FG6M2DANE99WU2'); // this is also valid for developing
```

Secondly prepare the required parameters:

```php
$parameters = [
    'paymentType' => 'CCARD', // optional, default SELECT
    'transactionId' => 'TX54434',
    'currency' => 'EUR',
    'description' => 'Awesome Product',
    'language' => 'EN',
    'returnUrl' => 'http://your-website.com/response?type=success',
    'cancelUrl' => 'http://your-website.com/response?type=cancel',
    'notifyUrl' => 'http://your-website.com/response?type=notify',
    'serviceUrl' => 'http://your-website.com/response?type=service',
    'imageUrl' => 'http://your-website.com/logo.png', // optional
    'amount' => '100.00'
];
```

If any required parameter is missing you will get an InvalidRequestException when you create the request:

```php
$request = $gateway->purchase($parameters);
```

Send the request:

```php
$response = $request->send();
```

Lastly handle the response:

```php
if ($response->isRedirect()) {
    $response->redirect(); // redirect the browser to the Wirecard Checkout Page
} else {
    echo 'Error: ' . $response->getMessage();
}
```

If you would like to handle return urls from the Checkout page use this on your response page:

```php
$gateway = Omnipay\Omnipay::create('Wirecard');
$gateway->setCustomerId('D200001');
$gateway->setSecret('B8AKTPWBRMNBV455FG6M2DANE99WU2');
$request = $gateway->completePurchase();
$response = $request->send();

if ($response->isSuccessful()) {
    echo 'Succesful payment!';
} else if ($response->isCancelled()) {
    echo 'Payment has been cancelled.';
} else if ($response->isPending()) {
    echo 'Your payment is in pending status.';
} else {
    echo $response->getMessage();
}
```

The `getMessage()` and `getData()` methods are available in the response object for further actions.

## List of available payment types

Payment type is highly depended on your contract with Wirecard, but these are the currently available values:

| Type | Description |
|---|---|
| BANCONTACT_MISTERCASH | Bancontact/Mister Cash |
| C2P | CLICK2PAY |
| CCARD | Credit Card |
| CCARD-MOTO | Credit Card Mail Order, Telephone Order |
| EKONTO | eKonto |
| SEPA-DD | SEPA Direct Debit |
| EPS | EPS |
| GIROPAY | giropay |
| IDL | iDEAL |
| INSTALLMENT | Installment |
| INVOICE | Invoice |
| MAESTRO | Maestro SecureCode |
| MONETA | moneta.ru |
| MPASS | mpass |
| PRZELEWY24 | Przelewy24 |
| PAYPAL | PayPal |
| PBX | Paybox |
| POLI | POLi payments |
| PSC | Paysafecard |
| QUICK | @Quick |
| SKRILLDIRECT | Skrill Direct |
| SKRILLWALLET | Skrill Digital Wallet |
| SOFORTUEBERWEISUNG | sofort.com |
| TRUSTLY | Trustly |
