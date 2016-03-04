# omnipay-wirecard
Wirecard gateway for Omnipay (http://omnipay.thephpleague.com) payment processing library.

This library only supports Wirecard Checkout Page payment yet. You can read more about the Checkout Page solution here:
https://www.wirecard.at/en/solutions/products/checkout-page/

## Using

Firstly create the gateway:

        $gateway = Omnipay\Omnipay::create('Wirecard_Checkout');
        $gateway->setCustomerId('D200001'); // this is a valid demo customer id
        $gateway->setSecret('B8AKTPWBRMNBV455FG6M2DANE99WU2'); // this is also valid for developing

After that prepare the required parameters.

        $parameters = [
            'paymentType' => 'CCARD',
            'shopId' => '1234', // optional
            'currency' => 'EUR',
            'description' => 'Awesome Product',
            'language' => 'en',
            'successUrl' => 'your-website.com/response?type=success',
            'failureUrl' => 'your-website.com/response?type=failure',
            'cancelUrl' => your-website.com/response?type=cancel,
            'serviceUrl' => your-website.com/response?type=service,
            'amount' => '100.00'
        ];

If any required parameter is missing you will get an InvalidRequestException:

        $request = $gateway->purchase($parameters);

Send the request:

        $response = $request->send();

Handle the response:

        if ($response->isRedirect()) {
            $response->redirect(); // redirect the browser to the Wirecard Checkout Page
        } else {
            echo 'Error: '.$response->getMessage();
        }

Now you have to handle return urls from the Checkout page. On your response page use:

        $gateway = Omnipay\Omnipay::create('Wirecard_Checkout');
        $gateway->setCustomerId('D200001');
        $gateway->setSecret('B8AKTPWBRMNBV455FG6M2DANE99WU2');
        $request = $gateway->completePurchase();
        $response = $request->send();

        echo $response->getMessage();


## List of possible payment types

Available payment types are depended by your contract with Wirecard, but these are the currently available values:

- "BANCONTACT_MISTERCASH" - Bancontact/Mister Cash
- "C2P" - CLICK2PAY
- "CCARD" - Credit Card
- "CCARD-MOTO" - Credit Card Mail Order, Telephone Order
- "EKONTO" - eKonto
- "SEPA-DD" - SEPA Direct Debit
- "EPS" - EPS
- "GIROPAY" - giropay
- "IDL" - iDEAL
- "INSTALLMENT" - Installment
- "INVOICE" - Invoice
- "MAESTRO" - Maestro SecureCode
- "MONETA" - moneta.ru
- "MPASS" - mpass
- "PRZELEWY24" - Przelewy24
- "PAYPAL" - PayPal
- "PBX" - Paybox
- "POLI" - POLi payments
- "PSC" - Paysafecard
- "QUICK" - @Quick
- "SKRILLDIRECT" - Skrill Direct
- "SKRILLWALLET" - Skrill Digital Wallet
- "SOFORTUEBERWEISUNG " - sofort.com
- "TRUSTLY" - Trustly

## To-do
- Handling custom parameters (like customerStatement, duplicateRequestCheck, displayText, imageUrl, etc.)
- Unit tests
- Checkout Seamless integration (https://www.wirecard.at/en/solutions/products/checkout-seamless/)