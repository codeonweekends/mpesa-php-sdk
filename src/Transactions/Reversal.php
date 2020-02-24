<?php
/**
 * @copyright 2019.
 * @author Amandio Khuta Nhamande <amandio16@gmail.com>
 * @license MIT
 */

namespace Codeonweekends\MPesa\Transactions;

use Codeonweekends\MPesa\Context;
use Codeonweekends\MPesa\Interfaces\TransactionsInterface;
use Codeonweekends\MPesa\MethodType;
use Codeonweekends\MPesa\Request;
use Codeonweekends\MPesa\Response;

class Reversal implements TransactionsInterface
{
    /**
     * @var $amount
     */
    private $amount;

    /**
     * @var string $service_provider_code
     */
    private $service_provider_code;

    /**
     * @var string $transaction_id
     */
    private $transaction_id;

    /**
     * @var string $security_credential
     */
    private $security_credential;

    /**
     * @var string $initiator_identifier
     */
    private $initiator_identifier;

    /**
     * @var string $third_party_reference
     */
    private $third_party_reference;

    /**
     * @var array $config
     */
    protected $config;

    /**
     * @var Context $apiContext
     */
    protected $apiContext;

    /**
     * @var Response $response
     */
    protected $response;

    public function __construct($amount, $transaction_id, $third_party_reference)
    {
        $this->config = require_once(__DIR__ . '/../config.php');
        $this->security_credential = $this->config['security_credential'];
        $this->initiator_identifier = $this->config['initiator_identifier'];
        $this->amount = $amount;
        $this->service_provider_code = $this->config['service_provider_code'];
        $this->transaction_id = $transaction_id;
        $this->third_party_reference = $third_party_reference;
    }

    /**
     * @throws \Exception
     */
    public function send(): void
    {
        $this->apiContext->setPort($this->config['ports']['reversal']);
        $this->apiContext->setPath($this->config['paths']['reversal']);
        $this->apiContext->setMethodType(MethodType::PUT);

        $this->apiContext->addParameter('input_TransactionID', $this->transaction_id);
        $this->apiContext->addParameter('input_SecurityCredential', $this->security_credential);
        $this->apiContext->addParameter('input_InitiatorIdentifier', $this->initiator_identifier);
        $this->apiContext->addParameter('input_ThirdPartyReference', $this->third_party_reference);
        $this->apiContext->addParameter('input_ServiceProviderCode', $this->service_provider_code);
        $this->apiContext->addParameter('input_ReversalAmount', $this->amount);

        $request = new Request($this->apiContext);

        $this->setResponse($request->execute());
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getServiceProviderCode(): string
    {
        return $this->service_provider_code;
    }

    /**
     * @param string $service_provider_code
     */
    public function setServiceProviderCode(string $service_provider_code): void
    {
        $this->service_provider_code = $service_provider_code;
    }

    /**
     * @return string
     */
    public function getTransactionId(): string
    {
        return $this->transaction_id;
    }

    /**
     * @param string $transaction_id
     */
    public function setTransactionId(string $transaction_id): void
    {
        $this->transaction_id = $transaction_id;
    }

    /**
     * @return string
     */
    public function getSecurityCredential(): string
    {
        return $this->security_credential;
    }

    /**
     * @param string $security_credential
     */
    public function setSecurityCredential(string $security_credential): void
    {
        $this->security_credential = $security_credential;
    }

    /**
     * @return string
     */
    public function getInitiatorIdentifier(): string
    {
        return $this->initiator_identifier;
    }

    /**
     * @param string $initiator_identifier
     */
    public function setInitiatorIdentifier(string $initiator_identifier): void
    {
        $this->initiator_identifier = $initiator_identifier;
    }

    /**
     * @return string
     */
    public function getThirdPartyReference(): string
    {
        return $this->third_party_reference;
    }

    /**
     * @param string $third_party_reference
     */
    public function setThirdPartyReference(string $third_party_reference): void
    {
        $this->third_party_reference = $third_party_reference;
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config): void
    {
        $this->config = $config;
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
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * @param Response $response
     */
    public function setResponse(Response $response): void
    {
        $this->response = $response;
    }
}