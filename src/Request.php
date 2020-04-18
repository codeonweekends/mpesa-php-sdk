<?php
/**
 * @copyright 2019.
 * @author Amandio Khuta Nhamande <amandio16@gmail.com>
 * @license MIT
 */

namespace CodeonWeekends\MPesa;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ConnectException;

/**
 * Class APIRequest
 * @package Codeonweekends\MPesa
 */
class Request extends MethodType
{
    /**
     * @var Context|NULL
     */
    protected $context;

    /**
     * @var HttpClient
     */
    protected $http;

    /**
     * APIRequest constructor.
     * @param Context|NULL $context
     */
    public function __construct(Context $context = NULL)
    {
        $this->context = $context;
        $this->http = new HttpClient();
    }

    /**
     * @return Response
     * @throws \Exception
     */
    public function execute(): Response
    {
        if ($this->context == NULL) {
            throw new \Exception('API Context not provided.', '500');
        }

        $this->defaultHeaders();

        switch ($this->context->getMethodType()) {
            case self::GET:
                return $this->getRequest();
                break;

            case self::POST:
                return $this->postRequest();
                break;

            case self::PUT:
                return $this->putRequest();
                break;

            default:
                throw new \Exception('Unknown Method Type', '403');
                break;
        }
    }

    /**
     * Executes a GET request
     *
     * @return array|Response
     */
    private function getRequest()
    {
        try {
            $response = $this->http->get($this->context->getUrl(), [
                'query' => $this->context->getParameters(),
                'headers' => $this->context->getHeaders(),
                'http_errors' => FALSE
            ]);

            return new Response($response);
        } catch (ConnectException $e) {
            return $this->connectException($e);
        }
    }

    /**
     * Executes a POST request
     *
     * @return array|Response
     */
    private function postRequest()
    {
        try {
            $response = $this->http->post($this->context->getUrl(), [
                'json' => $this->context->getParameters(),
                'headers' => $this->context->getHeaders(),
                'http_errors' => FALSE
            ]);

            return new Response($response);
        } catch (ConnectException $e) {
            return $this->connectException($e);
        }
    }

    /**
     * Executes a PUT request
     *
     * @return array|Response
     */
    private function putRequest()
    {
        try {
            $response = $this->http->get($this->context->getUrl(), [
                'json' => $this->context->getParameters(),
                'headers' => $this->context->getHeaders(),
                'http_errors' => FALSE
            ]);

            return new Response($response);
        } catch (ConnectException $e) {
            return $this->connectException($e);
        }
    }

    /**
     * Set default request headers for the current context
     * @throws \Exception
     */
    public function defaultHeaders(): void
    {
        if ($this->context->getToken() == NULL) {
            throw new \Exception('API Token not found.', '404');
        }

        $this->context->addHeader('Authorization', 'Bearer ' . $this->context->getToken());
        $this->context->addHeader('Content-Type', 'application/json');
        $this->context->addHeader('Host', $this->context->getHost());
        $this->context->addHeader("Origin", "*");
    }

    /**
     * @param Context $context
     */
    public function setContext(Context $context): void
    {
        $this->context = $context;
    }

    /**
     * @return Context
     */
    public function getContext(): Context
    {
        return $this->context;
    }

    /**
     * @param ConnectException $e
     * @return array
     */
    private function connectException(ConnectException $e) : array
    {
        return [
            'code' => $e->getCode(),
            'message' => 'Erro de conecção. Certifique-se que está conectado a internet e tente novamente.'
        ];
    }
}
