<?php
/**
 * @copyright 2019.
 * @author Amandio Khuta Nhamande <amandio16@gmail.com>
 * @license MIT
 */

return [
    'api_key' => '',
    'public_key' => '',
    'address' => 'api.sandbox.vm.co.mz',
    'ssl' => TRUE,

    'paths' => [
        'c2b' => '/ipg/v1x/c2bPayment/singleStage/',
        'status' => '/ipg/v1x/queryTransactionStatus/',
        'reversal' => '/ipg/v1x/reversal/'
    ],

    'ports' => [
        'c2b' => 18352,
        'status' => 18353,
        'reversal' => 18354
    ]
];
