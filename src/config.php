<?php
/**
 * @copyright 2019.
 * @author Amandio Khuta Nhamande <amandio16@gmail.com>
 * @license MIT
 */

return [
    'api_key' => env('MPESA_API_KEY'),
    'public_key' => env('MPESA_PUBLIC_KEY'),
    'service_provider_code' => env('MPESA_SERVICE_PROVIDER'),
    'security_credential' => env('MPESA_SECURITY_CREDENTIAL'),
    'initiator_identifier' => env('MPESA_INITIATOR_IDENTIFIER'),
    'host' => env('MPESA_HOST', 'api.sandbox.vm.co.mz'),
    'ssl' => env('MPESA_SSL', TRUE),

    'paths' => [
        'c2b' => '/ipg/v1x/c2bPayment/singleStage/',
        'b2b' => '/ipg/v1x/b2bPayment/',
        'b2c' => '/ipg/v1x/b2cPayment/',
        'status' => '/ipg/v1x/queryTransactionStatus/',
        'reversal' => '/ipg/v1x/reversal/'
    ],

    'ports' => [
        'c2b' => 18352,
        'b2b' => 18349,
        'b2c' => 18345,
        'status' => 18353,
        'reversal' => 18354
    ]
];
