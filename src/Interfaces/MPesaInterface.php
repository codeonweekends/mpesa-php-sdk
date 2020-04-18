<?php
/**
 * @copyright 2019.
 * @author Amandio Khuta Nhamande <amandio16@gmail.com>
 * @license MIT
 *
 */

namespace CodeonWeekends\MPesa\Interfaces;

/**
 * Interface MPesaInterface
 * @package Codeonweekends\MPesa
 */
interface MPesaInterface
{
    /**
     * The C2B API Call is used as a standard customer-to-business transaction.
     * Funds from the customer’s mobile money wallet will be deducted and be transferred to the mobile money wallet of the business.
     * To authenticate and authorize this transaction, M-Pesa Payments Gateway will initiate a USSD Push message to the customer to gather and verify the mobile money PIN number.
     * This number is not stored and is used only to authorize the transaction.
     *s
     * @param string $thirdPartyReference
     * @param int $amount
     * @param string $customerMSISDN
     * @param string $serviceProviderCode
     * @param string $transactionReference
     * @return mixed
     */
    public function c2b ($thirdPartyReference = '', $amount = 0, $customerMSISDN = '', $serviceProviderCode = '', $transactionReference = '');

    /**
     * The C2B API Call is used as a standard customer-to-business transaction.
     * Funds from the customer’s mobile money wallet will be deducted and be transferred to the mobile money wallet of the business.
     * To authenticate and authorize this transaction, M-Pesa Payments Gateway will initiate a USSD Push message to the customer to gather and verify the mobile money PIN number.
     * This number is not stored and is used only to authorize the transaction.
     *
     * @param $transactionReference
     * @param $CustomerMSISDN
     * @param $amount
     * @param $thirdPartyReference
     * @param $serviceProviderCode
     * @return mixed
     */
    public function b2c($transactionReference, $CustomerMSISDN, $amount, $thirdPartyReference, $serviceProviderCode);

    /**
     * The B2B API Call is used as a standard business-to-business transaction.
     * Funds from the business’ mobile money wallet will be deducted and transferred
     * to the mobile money wallet of the third party business.
     *
     * @param $transactionReference
     * @param $amount
     * @param $thirdPartyReference
     * @param $primaryPartyCode
     * @param $receiverPartyCode
     * @return mixed
     */
    public function b2b($transactionReference, $amount, $thirdPartyReference, $primaryPartyCode, $receiverPartyCode);

    /**
     * The Query Transaction Status API is used to determine the current status of a particular transaction.
     * Using either the Transaction ID or the Conversation ID of the transaction from the Mobile Money Platform,
     * the M-Pesa Payments Gateway will return information about the transaction’s status.
     *
     *
     * @param string $queryReference
     * @param string $thirdPartyReference
     * @return mixed
     */
    public function transactionStatus ($queryReference = '', $thirdPartyReference = '');

    /**
     * The Reversal API is used to reverse a successful transaction. Using the Transaction ID of a previously successful transaction,
     * M-Pesa Payments Gateway will withdraw the funds from the recipient party’s mobile money wallet and revert the funds
     * to the mobile money wallet of the initiating party of the original transaction.
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