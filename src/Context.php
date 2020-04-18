<?php

namespace CodeonWeekends\MPesa;

use Codeonweekends\MPesa\Transactions\C2B;
use Codeonweekends\MPesa\Transactions\Reversal;
use Codeonweekends\MPesa\Transactions\Status;

/**
 * Class APIContext
 * @package Codeonweekends\MPesa
 */
class Context
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var string
     */
    protected $public_key;

    /**
     * @var string
     */
    protected $api_key;

    /**
     * @var bool
     */
    protected $ssl;

    /**
     * @var int
     */
    protected $method_type;

    /**
     * @var string $host
     */
    protected $host;

    /**
     * @var int
     */
    protected $port;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var array
     */
    protected $headers;

    /**
     * @var array
     */
    protected $parameters;

    /**
     * Transaction object representing one of the available transactions
     * @var C2B | Status | Reversal
     */
    protected $transaction;

    public function __construct()
    {
        $this->config = require(__DIR__ . '/config.php');

        $this->method_type = MethodType::GET;
        $this->headers = [];
        $this->parameters = [];
        $this->port = 80;
        $this->path = '';
        $this->host = $this->config['host'];
        $this->ssl = $this->config['ssl'];
        $this->public_key = $this->config['public_key'];
        $this->api_key = $this->config['api_key'];
    }

    /**
     * Creates a well formatted URL
     *
     * @return string
     */
    public function getUrl(): string
    {
        $url = $this->host . ':' . $this->port . $this->path;
        $http = 'http://' . $url;
        $https = 'https://' . $url;

        return $this->ssl ? $https : $http;
    }

    /**
     * Generates a base64 encoded token
     *
     * @return string
     */
    public function getToken(): string
    {
        if (!empty($this->public_key) && !empty($this->api_key))
        {
            $key = "-----BEGIN PUBLIC KEY-----\n";
            $key .= wordwrap($this->public_key, 60, "\n", true);
            $key .= "\n-----END PUBLIC KEY-----";
            $public_key = openssl_get_publickey($key);

            openssl_public_encrypt($this->api_key, $token, $public_key, OPENSSL_PKCS1_PADDING);

            return base64_encode($token);
        }
        return NULL;
    }

    /**
     * @param $key
     * @param $value
     */
    public function addHeader($key, $value): void
    {
        $this->headers[$key] = $value;
    }

    /**
     * @param $key
     * @param $value
     */
    public function addParameter($key, $value): void
    {
        $this->parameters[$key] = $value;
    }

    /**
     * @return string
     */
    public function getPublicKey(): string
    {
        return $this->public_key;
    }

    /**
     * @param $value
     */
    public function setPublicKey($value): void
    {
        $this->public_key = $value;
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->api_key;
    }

    /**
     * @param $value
     */
    public function setApiKey($value): void
    {
        $this->api_key = $value;
    }

    /**
     * @return bool
     */
    public function getSSL(): bool
    {
        return $this->ssl;
    }

    /**
     * @param $value
     */
    public function setSSL($value): void
    {
        $this->ssl = $value;
    }

    /**
     * @return int
     */
    public function getMethodType(): int
    {
        return $this->method_type;
    }

    /**
     * @param $value
     */
    public function setMethodType($value): void
    {
        $this->method_type = $value;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @param $value
     */
    public function setPort($value): void
    {
        $this->port = $value;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param $value
     */
    public function setPath($value): void
    {
        $this->path = $value;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getHeader($key)
    {
        return $this->headers[$key];
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getParameter($key)
    {
        return $this->parameters[$key];
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost($host): void
    {
        $this->host = $host;
    }
}
