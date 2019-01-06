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
$thirdPartyReference = 11114;
$amount = 10;
$customerMSISDN = 258843330333;
$serviceProviderCode = 171717;
$transactionReference = 'T12344C';

$c2b = $mpesa->c2b($thirdPartyReference, $amount, $customerMSISDN, $serviceProviderCode, $transactionReference);
```

## View a Transaction Status

```php
$queryReference = '5C1400CVRO';
$serviceProviderCode = '171717';
$securityCredential = 'Mpesa2019';
$initiatorIdentifier = 'Mpesa2018';

$status = $mpesa->transactionStatus($queryReference, $serviceProviderCode, $securityCredential, $initiatorIdentifier);
```

## Transaction Reversal

```php
$amount = 10;
$serviceProviderCode = 171717; 
$transactionID = '49XCDF6';
$securityCredential = 'Mpesa2019';
$initiatorIdentifier = 'Mpesa2018';

$reversal = $mpesa->transactionReversal($amount, $serviceProviderCode, $transactionID, $securityCredential, $initiatorIdentifier);
```
