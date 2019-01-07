<?php
/**
 * @copyright 2019.
 * @author Amandio Khuta Nhamande <amandio16@gmail.com>
 * @license MIT
 */

namespace Codeonweekends\MPesa;

/**
 * Interface MPesaInterface
 * @package Codeonweekends\MPesa
 */
interface MPesaInterface
{
    /**
     * Do a customer-to-business transaction.
     *
     * The default amount is set to 10 because the minimum transaction
     * value for the m-pesa payments is 10.
     *
     * @param string $thirdPartyReference
     * @param int $amount
     * @param string $customerMSISDN
     * @param string $serviceProviderCode
     * @param string $transactionReference
     * @return mixed
     */
    public function c2b ($thirdPartyReference = '', $amount = 10, $customerMSISDN = '', $serviceProviderCode = '', $transactionReference = '');

    /**
     * Retrieves a transaction status.
     *
     *
     * @param string $queryReference
     * @param string $serviceProviderCode
     * @param string $securityCredential
     * @param string $initiatorIdentifier
     * @return mixed
     */
    public function transactionStatus ($queryReference = '', $serviceProviderCode = '', $securityCredential = '', $initiatorIdentifier = '');

    /**
     * Reverses a successful transaction
     *
     * The default amount is set to 10 because the minimum transaction
     * value for the m-pesa payments is 10.
     *
     * @param int $amount
     * @param string $serviceProviderCode
     * @param string $transactionID
     * @param string $securityCredential
     * @param string $initiatorIdentifier
     * @return mixed
     */
    public function transactionReversal ($amount = 10, $serviceProviderCode = '', $transactionID = '', $securityCredential = '', $initiatorIdentifier = '');
}