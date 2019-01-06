# Install using Composer
```composer require codeonweekends/mpesa-php-sdk```

# Usage
The easiest way to use the API is by calling ``Codeonweekends\Mpesa\Mpesa`` and accessing
the available transaction methods.

- Create an instance of ``Codeonweekends\Mpesa\Mpesa``
- Get the api context using the ``getApiContext()`` method
- Set the public key and the api key on the context using ``setPublicKey(YOUR_PUBLIC_KEY)`` and ``setApiKey(YOUR_API_KEY)`` respectively

Example:
```php
$mpesa = new Codeonweekends\Mpesa\Mpesa();
$context = $mpesa->getApiContext();

$context->setPublicKey(YOUR_PUBLIC_KEY);
$context->setApiKey(YOUR_API_KEY);
```


## Create a C2B Transaction

```php
$thirdPartyReference = 'Your third party reference';
$amount = 10;
$customerMSISDN = 258840000000;
$serviceProviderCode = YOUR_PROVIDER_CODE;
$transactionReference = 'Transaction Reference';

$c2b = $mpesa->c2b($thirdPartyReference, $amount, $customerMSISDN, $serviceProviderCode, $transactionReference);
```

## View a Transaction Status

```php
$queryReference = '5C1400CVRO';
$serviceProviderCode = '171717';
$securityCredential = YOUR_SECURITY_CREDENTIAL';
$initiatorIdentifier = YOUR_INITIATOR_IDENTIFIER';

$status = $mpesa->transactionStatus($queryReference, $serviceProviderCode, $securityCredential, $initiatorIdentifier);
```

## Transaction Reversal

```php
$amount = 10;
$serviceProviderCode = YOUR_PROVIDER_CODE; 
$transactionID = '49XCDF6';
$securityCredential = YOUR_SECURITY_CREDENTIAL;
$initiatorIdentifier = YOUR_INITIATOR_IDENTIFIER';

$reversal = $mpesa->transactionReversal($amount, $serviceProviderCode, $transactionID, $securityCredential, $initiatorIdentifier);
```
# Further Improvements

* Documentation
* Laravel support