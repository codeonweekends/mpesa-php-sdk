<?php
/**
 * @copyright 2019.
 * @author Amandio Khuta Nhamande <amandio16@gmail.com>
 * @license MIT
 */

namespace CodeonWeekends\MPesa\Transactions;

use CodeonWeekends\MPesa\Context;
use CodeonWeekends\MPesa\MethodType;
use CodeonWeekends\MPesa\Request;
use CodeonWeekends\MPesa\Interfaces\TransactionsInterface;
use CodeonWeekends\MPesa\Response;

class C2B implements TransactionsInterface
{
    /**
     * @var string $thirdPartyReference
     */
    private $thirdPartyReference;

    /**
     * @var double $amount
     */
    private $amount;

    /**
     * @var string $customerMSISDN
     */
    private $customerMSISDN;

    /**
     * @var string $serviceProviderCode
     */
    private $serviceProviderCode;

    /**
     * @var string $transactionReference
     */
    private $transactionReference;

    /**
     * @var Response $response
     */
    protected $response;

    /**
     * @var Context $apiContext
     */
    protected $apiContext;

    /**
     * @var array $config
     */
    protected $config;

    /**
     * C2B constructor.
     * @param string $thirdPartyReference
     * @param double $amount
     * @param string $customerMSISDN
     * @param string $serviceProviderCode
     * @param string $transactionReference
     */
    public function __construct($transactionReference, $amount, $customerMSISDN, $thirdPartyReference, $serviceProviderCode)
    {
        $this->config = require(__DIR__ . '/../config.php');
        $this->transactionReference = $transactionReference;
        $this->customerMSISDN = $customerMSISDN;
        $this->amount = $amount;
        $this->thirdPartyReference = $thirdPartyReference;
        $this->serviceProviderCode = $serviceProviderCode;

        $this->apiContext = new Context();
    }

    /**
     * @throws \Exception
     */
    public function send (): void
    {
        $this->apiContext->setPort($this->config['ports']['c2b']);
        $this->apiContext->setPath($this->config['paths']['c2b']);
        $this->apiContext->setMethodType(MethodType::POST);

        $this->apiContext->addParameter('input_ThirdPartyReference', $this->thirdPartyReference);
        $this->apiContext->addParameter('input_Amount', $this->amount);
        $this->apiContext->addParameter('input_CustomerMSISDN',$this->customerMSISDN);
        $this->apiContext->addParameter('input_ServiceProviderCode', $this->serviceProviderCode);
        $this->apiContext->addParameter('input_TransactionReference', $this->transactionReference);

        $request = new Request($this->apiContext);

        $this->setResponse($request->execute());
    }

    /**
     * @return string
     */
    public function getThirdPartyReference(): string
    {
        return $this->thirdPartyReference;
    }

    /**
     * @param string $thirdPartyReference
     */
    public function setThirdPartyReference(string $thirdPartyReference): void
    {
        $this->thirdPartyReference = $thirdPartyReference;
    }

    /**
     * @return double
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param double $amount
     */
    public function setAmount($amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getCustomerMSISDN(): string
    {
        return $this->customerMSISDN;
    }

    /**
     * @param string $customerMSISDN
     */
    public function setCustomerMSISDN(string $customerMSISDN): void
    {
        $this->customerMSISDN = $customerMSISDN;
    }

    /**
     * @return string
     */
    public function getServiceProviderCode(): string
    {
        return $this->serviceProviderCode;
    }

    /**
     * @param string $serviceProviderCode
     */
    public function setServiceProviderCode(string $serviceProviderCode): void
    {
        $this->serviceProviderCode = $serviceProviderCode;
    }

    /**
     * @return string
     */
    public function getTransactionReference(): string
    {
        return $this->transactionReference;
    }

    /**
     * @param string $transactionReference
     */
    public function setTransactionReference(string $transactionReference): void
    {
        $this->transactionReference = $transactionReference;
    }

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * @param $response
     */
    public function setResponse($response): void
    {
        $this->response = $response;
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
}