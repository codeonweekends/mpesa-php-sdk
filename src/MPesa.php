<?php
/**
 * Created by PhpStorm.
 * User: Anonymous
 * Date: 04-01-2019
 * Time: 08:20
 */

namespace Codeonweekends\MPesa;

class MPesa
{
    protected $apiContext;
    protected $baseUrl;
    protected $port;

    public function __construct (APIContext $apiContext = NULL, $publicKey = '', $apiKey = '', $address = '', $port = '')
    {
        $this->baseUrl = !empty($address) ? $address : 'api.sandbox.vm.co.mz';
        $this->apiContext = $apiContext ? $apiContext : new APIContext($publicKey, $apiKey, TRUE, APIMethodType::GET, $this->baseUrl, $this->port);
    }

    /**
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
        $context->setPort('18347');
        $context->setPath("/ipg/v1/queryTxn/");
        $context->addHeader("Origin", "*");
        $context->addParameter('input_QueryReference', $queryReference);
        $context->addParameter('input_ServiceProviderCode', $serviceProviderCode);
        $context->addParameter('input_SecurityCredential',$securityCredential);
        $context->addParameter('input_InitiatorIdentifier', $initiatorIdentifier);

        $request = new APIRequest($context);
        $response = $request->execute();

        return json_decode($response->getBody());
    }

    public function c2b ($thirdPartyReference, $amount, $customerMSISDN, $serviceProviderCode, $transactionReference)
    {
        $context = $this->apiContext;
        $context->setPort('18346');
        $context->setPath("/ipg/v1/c2bpayment/");
        $context->setMethodType(APIMethodType::POST);
        $context->addHeader("Origin", "*");
        $context->addParameter('input_ThirdPartyReference', $thirdPartyReference);
        $context->addParameter('input_Amount', $amount);
        $context->addParameter('input_CustomerMSISDN',$customerMSISDN);
        $context->addParameter('input_ServiceProviderCode', $serviceProviderCode);
        $context->addParameter('input_TransactionReference', $transactionReference);

//        return $context;
        $request = new APIRequest($context);
        $response = $request->execute();

        return json_decode($response->getBody());
    }

    public function reversal ()
    {}

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