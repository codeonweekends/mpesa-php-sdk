<?php
/**
 * @copyright 2019.
 * @author Amandio Khuta Nhamande <amandio16@gmail.com>
 * @license MIT
 */

namespace Codeonweekends\MPesa;

use Codeonweekends\MPesa\Transactions\C2B;
use Codeonweekends\MPesa\Transactions\Status;

/**
 * Class MPesa
 * @package Codeonweekends\MPesa
 */
class MPesa implements Interfaces\MPesaInterface
{
    /**
     * @var Context|NULL
     */
    protected $apiContext;

    /**
     * @var mixed
     */
    protected $config;

    protected const TRANSACTION_STATUS_PORT = 18347;
    protected const TRANSACTION_STATUS_PATH = '/ipg/v1/queryTxn/';
    protected const TRANSACTION_REVERSAL_PORT = 18348;
    protected const TRANSACTION_REVERSAL_PATH = '/ipg/v1/reversal/';

    public function __construct ()
    {
        $this->config = require(__DIR__ . '/config.php');
        $this->apiContext = new Context();
        $this->apiContext->addHeader("Origin", "*");
    }

    /**
     * Retrieves a transaction status.
     *
     *
     * @param string $queryReference
     * @param string $thirdPartyReference
     * @return mixed
     * @throws \Exception
     */
    public function transactionStatus ($thirdPartyReference = '', $queryReference = '')
    {
        $status = new Status($thirdPartyReference, $queryReference);
        $status->setApiContext($this->apiContext);
        $status->send();

        return $status->getResponse();
    }

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
     * @throws \Exception
     */
    public function c2b ($transactionReference = '', $amount = 10, $customerMSISDN = '', $thirdPartyReference = '', $serviceProviderCode = '')
    {
        $c2b = new C2B($transactionReference, $amount, $customerMSISDN, $thirdPartyReference, $serviceProviderCode);
        $c2b->setApiContext($this->apiContext);
        $c2b->send();

        return $c2b->getResponse();
    }

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
     * @throws \Exception
     */
    public function transactionReversal ($amount = 10, $serviceProviderCode = '', $transactionID = '', $securityCredential = '', $initiatorIdentifier = '')
    {
        $context = $this->apiContext;
        $context->setPort(self::TRANSACTION_REVERSAL_PORT);
        $context->setPath(self::TRANSACTION_REVERSAL_PATH);
        $context->setMethodType(MethodType::PUT);
        $context->addParameter('input_Amount', $amount);
        $context->addParameter('input_ServiceProviderCode', $serviceProviderCode);
        $context->addParameter('input_TransactionID', $transactionID);
        $context->addParameter('input_SecurityCredential', $securityCredential);
        $context->addParameter('input_InitiatorIdentifier', $initiatorIdentifier);

        $request = new Request($context);
        $response = $request->execute();

        return json_decode($response->getBody());
    }

    /**
     * @return Context
     */
    public function getApiContext(): Context
    {
        return $this->apiContext;
    }

    /**
     * @param Context $apiContext
     */
    public function setApiContext(Context $apiContext): void
    {
        $this->apiContext = $apiContext;
    }

    /**
     *
     * @param $transactionReference
     * @param $CustomerMSISDN
     * @param $amount
     * @param $thirdPartyReference
     * @param $serviceProviderCode
     * @return mixed
     */
    public function b2c($transactionReference, $CustomerMSISDN, $amount, $thirdPartyReference, $serviceProviderCode)
    {
        // TODO: Implement b2c() method.
    }

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
    public function b2b($transactionReference, $amount, $thirdPartyReference, $primaryPartyCode, $receiverPartyCode)
    {
        // TODO: Implement b2b() method.
    }
}