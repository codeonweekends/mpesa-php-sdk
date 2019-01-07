<?php
/**
 * @copyright 2019.
 * @author Amandio Khuta Nhamande <amandio16@gmail.com>
 * @license MIT
 */

namespace Codeonweekends\MPesa;

/**
 * Class MPesa
 * @package Codeonweekends\MPesa
 */
class MPesa implements MPesaInterface
{
    /**
     * @var APIContext|NULL
     */
    protected $apiContext;

    protected const BASE_URI = 'api.sandbox.vm.co.mz';
    protected const C2B_PORT = 18346;
    protected const C2B_PATH = '/ipg/v1/c2bpayment/';
    protected const TRANSACTION_STATUS_PORT = 18347;
    protected const TRANSACTION_STATUS_PATH = '/ipg/v1/queryTxn/';
    protected const TRANSACTION_REVERSAL_PORT = 18348;
    protected const TRANSACTION_REVERSAL_PATH = '/ipg/v1/reversal/';

    /**
     * MPesa constructor.
     * @param APIContext|NULL $apiContext
     * @param string $publicKey
     * @param string $apiKey
     */
    public function __construct (APIContext $apiContext = NULL, $publicKey = '', $apiKey = '')
    {
        $this->apiContext = $apiContext ? $apiContext : new APIContext($publicKey, $apiKey, TRUE, APIMethodType::GET, self::BASE_URI);
        $this->apiContext->addHeader("Origin", "*");
    }

    /**
     * Retrieves a transaction status.
     *
     *
     * @param string $queryReference
     * @param string $serviceProviderCode
     * @param string $securityCredential
     * @param string $initiatorIdentifier
     * @return mixed
     * @throws \Exception
     */
    public function transactionStatus ($queryReference = '', $serviceProviderCode = '', $securityCredential = '', $initiatorIdentifier = '')
    {
        $context = $this->apiContext;
        $context->setPort(self::TRANSACTION_STATUS_PORT);
        $context->setPath(self::TRANSACTION_STATUS_PATH);
        $context->addParameter('input_QueryReference', $queryReference);
        $context->addParameter('input_ServiceProviderCode', $serviceProviderCode);
        $context->addParameter('input_SecurityCredential',$securityCredential);
        $context->addParameter('input_InitiatorIdentifier', $initiatorIdentifier);

        $request = new APIRequest($context);
        $response = $request->execute();

        return json_decode($response->getBody());
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
    public function c2b ($thirdPartyReference = '', $amount = 10, $customerMSISDN = '', $serviceProviderCode = '', $transactionReference = '')
    {
        $context = $this->apiContext;
        $context->setPort(self::C2B_PORT);
        $context->setPath(self::C2B_PATH);
        $context->setMethodType(APIMethodType::POST);
        $context->addParameter('input_ThirdPartyReference', $thirdPartyReference);
        $context->addParameter('input_Amount', $amount);
        $context->addParameter('input_CustomerMSISDN',$customerMSISDN);
        $context->addParameter('input_ServiceProviderCode', $serviceProviderCode);
        $context->addParameter('input_TransactionReference', $transactionReference);

        $request = new APIRequest($context);
        $response = $request->execute();

        return json_decode($response->getBody());
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
        $context->setMethodType(APIMethodType::PUT);
        $context->addParameter('input_Amount', $amount);
        $context->addParameter('input_ServiceProviderCode', $serviceProviderCode);
        $context->addParameter('input_TransactionID', $transactionID);
        $context->addParameter('input_SecurityCredential', $securityCredential);
        $context->addParameter('input_InitiatorIdentifier', $initiatorIdentifier);

        $request = new APIRequest($context);
        $response = $request->execute();

        return json_decode($response->getBody());
    }

    /**
     * @return APIContext
     */
    public function getApiContext(): APIContext
    {
        return $this->apiContext;
    }

    /**
     * @param APIContext $apiContext
     */
    public function setApiContext(APIContext $apiContext): void
    {
        $this->apiContext = $apiContext;
    }
}