<?php

namespace Codeonweekends\MPesa;

class APIResponse
{
    protected $statusCode;
    protected $headers;
    protected $body;
    protected $reasonPhrase;

    public function __construct($statusCode = '', $reasonPhrase = '', $headers = [], $body = [])
    {
        $this->statusCode = $statusCode;
        $this->headers = $headers;
        $this->body = $body;
        $this->reasonPhrase = $reasonPhrase;
    }

    public function setStatusCode($value)
    {
        return $this->statusCode = $value;
    }

    public function setReasonPhrase($value)
    {
        return $this->reasonPhrase = $value;
    }

    public function setHeaders($value)
    {
        return $this->headers = $value;
    }

    public function setBody($value)
    {
        return $this->body = $value;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getReasonPhrase()
    {
        return $this->reasonPhrase;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getBody()
    {
        return $this->body;
    }
}
