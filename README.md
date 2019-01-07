# Install using Composer
```composer require codeonweekends/mpesa-php-sdk```

# Usage
The easiest way to use the API is by calling ``Codeonweekends\Mpesa\Mpesa`` and accessing
the available transaction methods.

- Create an instance of ``Codeonweekends\Mpesa\Mpesa``
- Get the api context using the ``getApiContext()`` method
- Set the public key and the api key on the context using ``setPublicKey(YOUR_PUBLIC_KEY)`` and ``setApiKey(YOUR_API_KEY)`` respectively

<b>Example:</b>
```php
$mpesa = new Codeonweekends\Mpesa\Mpesa();
$context = $mpesa->getApiContext();

$context->setPublicKey(YOUR_PUBLIC_KEY);
$context->setApiKey(YOUR_API_KEY);
```


## Create a C2B Transaction

```php
$c2b = $mpesa->c2b($thirdPartyReference, $amount, $customerMSISDN, $serviceProviderCode, $transactionReference);
```

## View a Transaction Status

```php
$status = $mpesa->transactionStatus($queryReference, $serviceProviderCode, $securityCredential, $initiatorIdentifier);
```

## Transaction Reversal

```php
$reversal = $mpesa->transactionReversal($amount, $serviceProviderCode, $transactionID, $securityCredential, $initiatorIdentifier);
```

# Running Test Suite

1. Copy the file `phpunit.xml.example` and change the name to `phpunit.xml`
2. Open the file and fill the ``<env/>`` values with appropriate information
3. Run ```vendor/bin/phpunit```

<b>e.g.</b>
```xml
<env name="MPESA_PUBLIC_KEY" value="Your Public Key Here" />
<env name="MPESA_API_KEY" value="Your API Key Here" />
<env name="MPESA_SERVICE_PROVIDER_CODE" value="The Service Provider Code Here" />
<env name="MPESA_CUSTOMER_MSISDN" value="Customer MSISDN here" />
<env name="MPESA_SECURITY_CREDENTIAL" value="Security Credential" />
<env name="MPESA_INITIATOR_IDENTIFIER" value="Initiator Identifier" />
```

# Further Improvements

* Documentation
* Laravel support