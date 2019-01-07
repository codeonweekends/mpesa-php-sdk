<?php
/**
 * @copyright 2019.
 * @author Amandio Khuta Nhamande <amandio16@gmail.com>
 * @license MIT
 */

namespace Codeonweekends\MPesa;

/**
 * Class APIResponse
 * @package Codeonweekends\MPesa
 */
class APIResponse
{
    /**
     * @var string
     */
    protected $statusCode;

    /**
     * @var array
     */
    protected $headers;

    /**
     * @var array
     */
    protected $body;

    /**
     * @var string
     */
    protected $reasonPhrase;

    /**
     * APIResponse constructor.
     * @param null $response
     */
    public function __construct($response = NULL)
    {
        if ($response)
        {
            $this->statusCode = $response->getStatusCode();
            $this->headers = $response->getHeaders();
            $this->body = $response->getBody()->getContents();
            $this->reasonPhrase = $response->getReasonPhrase();

            $this->parse();
        }
    }

    /**
     * Parse the returned response content
     */
    private function parse (): void
    {
        // TODO Parse the response body
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setStatusCode($value)
    {
        return $this->statusCode = $value;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setReasonPhrase($value)
    {
        return $this->reasonPhrase = $value;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setHeaders($value)
    {
        return $this->headers = $value;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setBody($value)
    {
        return $this->body = $value;
    }

    /**
     * @return string
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getReasonPhrase()
    {
        return $this->reasonPhrase;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return array
     */
    public function getBody()
    {
        return $this->body;
    }
}
