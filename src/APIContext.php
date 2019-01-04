<?php

namespace Codeonweekends\MPesa;

use phpseclib\Crypt\RSA as CryptRSA;

class APIContext
{

    protected $publicKey;
    protected $apiKey;
    protected $ssl;
    protected $methodType;
    protected $address;
    protected $port;
    protected $path;
    protected $headers;
    protected $parameters;

    /**
     * APIContext constructor.
     * @param String|NULL $publicKey
     * @param String|NULL $apiKey
     * @param bool $ssl
     * @param int $methodType
     * @param string $address
     * @param int $port
     * @param string $path
     * @param array $headers
     * @param array $parameters
     */
    public function __construct(String $publicKey = NULL, String $apiKey = NULL, $ssl = TRUE, $methodType = APIMethodType::GET, $address = '', $port = 80, $path = '', $headers = [], $parameters = [])
    {
        $this->publicKey = $publicKey;
        $this->apiKey = $apiKey;
        $this->ssl = $ssl;
        $this->methodType = $methodType;
        $this->address = $address;
        $this->port = $port;
        $this->path = $path;
        $this->headers = $headers;
        $this->parameters = $parameters;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        $url = $this->address . ':' . $this->port . $this->path;
        $http = 'http://' . $url;
        $https = 'https://' . $url;

        return $this->ssl ? $https : $http;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        $rsa = new CryptRSA();

        $decodedPublicKey = base64_decode($this->publicKey);
        $rsa->loadKey($decodedPublicKey);
        $rsa->setEncryptionMode(CryptRSA::ENCRYPTION_PKCS1);
//        define('CRYPT_RSA_PKCS15_COMPAT', true); // Allow compatibility with openssl
        $cipherText = $rsa->encrypt($this->apiKey);
        $encodedApiKey = base64_encode($cipherText);

        return $encodedApiKey;
    }

    /**
     * @param $key
     * @param $value
     */
    public function addHeader($key, $value)
    {
        $this->headers[$key] = $value;
    }

    /**
     * @param $key
     * @param $value
     */
    public function addParameter($key, $value)
    {
        $this->parameters[$key] = $value;
    }

    /**
     * @return NULL|String
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }

    /**
     * @param $value
     */
    public function setPublicKey($value)
    {
        $this->publicKey = $value;
    }

    /**
     * @return NULL|String
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param $value
     */
    public function setApiKey($value)
    {
        $this->apiKey = $value;
    }

    /**
     * @return bool
     */
    public function getSSL()
    {
        return $this->ssl;
    }

    /**
     * @param $value
     */
    public function setSSL($value)
    {
        $this->ssl = $value;
    }

    /**
     * @return int
     */
    public function getMethodType()
    {
        return $this->methodType;
    }

    /**
     * @param $value
     */
    public function setMethodType($value)
    {
        $this->methodType = $value;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param $value
     */
    public function setAddress($value)
    {
        $this->address = $value;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param $value
     */
    public function setPort($value)
    {
        $this->port = $value;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param $value
     */
    public function setPath($value)
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
    public function getHeaders()
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
    public function getParameters()
    {
        return $this->parameters;
    }
}
