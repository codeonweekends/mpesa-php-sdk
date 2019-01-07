<?php
/**
 * @copyright 2019.
 * @author Amandio Khuta Nhamande <amandio16@gmail.com>
 * @license MIT
 */

namespace Codeonweekends\MPesa;

use GuzzleHttp\Client as HttpClient;

/**
 * Class APIRequest
 * @package Codeonweekends\MPesa
 */
class APIRequest
{
    /**
     * @var APIContext|NULL
     */
    protected $context;

    /**
     * @var HttpClient
     */
    protected $http;

    /**
     * APIRequest constructor.
     * @param APIContext|NULL $context
     */
    public function __construct(APIContext $context = NULL)
    {
        $this->context = $context;
        $this->http = new HttpClient();
    }

    /**
     * @return APIResponse
     * @throws \Exception
     */
    public function execute(): APIResponse
    {
        if ($this->context !== NULL) {
            $this->defaultHeaders();

            switch ($this->context->getMethodType()) {
                case APIMethodType::GET:
                    return $this->getRequest();
                    break;

                case APIMethodType::POST:
                    return $this->postRequest();
                    break;

                case APIMethodType::PUT:
                    return $this->putRequest();
                    break;

                default:
                    throw new \Exception("Unknown Method Type");
                    break;
            }
        }
    }

    /**
     * Executes a GET request
     *
     * @return APIResponse
     */
    private function getRequest(): APIResponse
    {
        $response = $this->http->get($this->context->getUrl(), [
            'query' => $this->context->getParameters(),
            'headers' => $this->context->getHeaders(),
            'http_errors' => FALSE
        ]);
        return new APIResponse($response);
    }

    /**
     * Executes a POST request
     *
     * @return APIResponse
     */
    private function postRequest(): APIResponse
    {
        $response = $this->http->post($this->context->getUrl(), [
            'json' => $this->context->getParameters(),
            'headers' => $this->context->getHeaders(),
            'http_errors' => FALSE
        ]);
        return new APIResponse($response);
    }

    /**
     * Executes a PUT request
     *
     * @return APIResponse
     */
    private function putRequest(): APIResponse
    {
        $response = $this->http->get($this->context->getUrl(), [
            'json' => $this->context->getParameters(),
            'headers' => $this->context->getHeaders(),
            'http_errors' => FALSE
        ]);
        return new APIResponse($response);
    }

    /**
     * Set default request headers for the current context
     */
    public function defaultHeaders(): void
    {
        $this->context->addHeader('Authorization', 'Bearer ' . $this->context->getToken());
        $this->context->addHeader('Content-Type', 'application/json');
        $this->context->addHeader('Host', $this->context->getAddress());
    }

    /**
     * @param APIContext $context
     */
    public function setContext(APIContext $context): void
    {
        $this->context = $context;
    }

    /**
     * @return APIContext
     */
    public function getContext(): APIContext
    {
        return $this->context;
    }
}
