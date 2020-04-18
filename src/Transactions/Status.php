<?php
/**
 * @copyright 2019.
 * @author Amandio Khuta Nhamande <amandio16@gmail.com>
 * @license MIT
 */

namespace CodeonWeekends\MPesa\Transactions;

use Codeonweekends\MPesa\Context;
use Codeonweekends\MPesa\Request;
use Codeonweekends\MPesa\Interfaces\TransactionsInterface;
use Codeonweekends\MPesa\Response;

class Status implements TransactionsInterface
{
    /**
     * @var $thirdPartyReference
     */
    private $thirdPartyReference;

    /**
     * @var $queryReference
     */
    private $queryReference;

    /**
     * @var $serviceProviderCode
     */
    private $serviceProviderCode;

    /**
     * @var Response $response
     */
    private $response;

    /**
     * @var $apiContext
     */
    protected $apiContext;

    /**
     * @var $config
     */
    protected $config;

    public function __construct($thirdPartyReference, $queryReference)
    {
        $this->config = require(__DIR__ . '/../config.php');
        $this->thirdPartyReference = $thirdPartyReference;
        $this->queryReference = $queryReference;
        $this->serviceProviderCode = $this->config['service_provider_code'];
        $this->apiContext = new Context();
    }

    /**
     * @throws \Exception
     */
    public function send(): void
    {
        $this->apiContext->setPort($this->config['ports']['status']);
        $this->apiContext->setPath($this->config['paths']['status']);
        $this->apiContext->addParameter('input_ThirdPartyReference', $this->thirdPartyReference);
        $this->apiContext->addParameter('input_QueryReference', $this->queryReference);
        $this->apiContext->addParameter('input_ServiceProviderCode', $this->serviceProviderCode);

        $request = new Request($this->apiContext);

        $this->setResponse($request->execute());
    }

    /**
     * @return mixed
     */
    public function getThirdPartyReference()
    {
        return $this->thirdPartyReference;
    }

    /**
     * @param mixed $thirdPartyReference
     */
    public function setThirdPartyReference($thirdPartyReference): void
    {
        $this->thirdPartyReference = $thirdPartyReference;
    }

    /**
     * @return mixed
     */
    public function getQueryReference()
    {
        return $this->queryReference;
    }

    /**
     * @param mixed $queryReference
     */
    public function setQueryReference($queryReference): void
    {
        $this->queryReference = $queryReference;
    }

    /**
     * @return mixed
     */
    public function getServiceProviderCode()
    {
        return $this->serviceProviderCode;
    }

    /**
     * @param mixed $serviceProviderCode
     */
    public function setServiceProviderCode($serviceProviderCode): void
    {
        $this->serviceProviderCode = $serviceProviderCode;
    }

    /**
     * @return mixed
     */
    public function getApiContext()
    {
        return $this->apiContext;
    }

    /**
     * @param mixed $apiContext
     */
    public function setApiContext($apiContext): void
    {
        $this->apiContext = $apiContext;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param Response $response
     */
    public function setResponse($response): void
    {
        $this->response = $response;
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param mixed $config
     */
    public function setConfig($config): void
    {
        $this->config = $config;
    }


}