<?php
/**
 * @copyright 2019.
 * @author Amandio Khuta Nhamande <amandio16@gmail.com>
 * @license MIT
 */

namespace CodeonWeekends\MPesa;

/**
 * Class APIResponse
 * @package Codeonweekends\MPesa
 */
class Response
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
     * @param $response
     */
    public function __construct($response = NULL)
    {
        if ($response)
        {
            $this->statusCode = $response->getStatusCode();
            $this->headers = $response->getHeaders();
            $this->body = json_decode($response->getBody()->getContents());
            $this->reasonPhrase = $response->getReasonPhrase();
        }
    }

    /**
     * Parse the returned response content
     */
    private function parse (): void
    {
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
