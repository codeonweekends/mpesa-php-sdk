<?php

namespace MPesa;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\RequestException;

class APIRequest
{
    protected $context;
    protected $http;

    public function __construct(APIContext $context = NULL)
    {
        $this->context = $context;
        $this->http = new HttpClient();
    }

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

    private function getRequest()
    {
        try {
            $response = $this->http->get($this->context->getUrl(), [
                'query' => $this->context->getParameters(),
                'headers' => $this->context->getHeaders()
            ]);
            return new APIResponse($response->getStatusCode(), $response->getReasonPhrase(), $response->getHeaders(), $response->getBody()->getContents());
        } catch (RequestException $e) {
            die($e->getMessage());
        }
    }

    private function postRequest()
    {
        try {
            $response = $this->http->post($this->context->getUrl(), [
                'form_params' => $this->context->getParameters(),
                'headers' => $this->context->getHeaders()
            ]);
            return new APIResponse($response->getStatusCode(), $response->getReasonPhrase(), $response->getHeaders(), $response->getBody()->getContents());
        } catch (RequestException $e) {
            die($e->getMessage());
        }
    }

    private function putRequest()
    {
        try {
            $response = $this->http->get($this->context->getUrl(), [
                'form_params' => $this->context->getParameters(),
                'headers' => $this->context->getHeaders()
            ]);
            return new APIResponse($response->getStatusCode(), $response->getReasonPhrase(), $response->getHeaders(), $response->getBody()->getContents());
        } catch (RequestException $e) {
            die($e->getMessage());
        }
    }

    public function defaultHeaders()
    {
        $this->context->addHeader('Authorization', 'Bearer ' . $this->context->getToken());
        $this->context->addHeader('Content-Type', 'application/json');
        $this->context->addHeader('Host', $this->context->getAddress());
    }

    public function setContext(APIContext $context)
    {
        $this->context = $context;
    }

    public function getContext(APIContext $context)
    {
        return $this->context;
    }
}
