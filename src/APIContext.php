<?php
namespace Codeonweekends\MPesa;

use Codeonweekends\MPesa\Transactions\C2B;
use Codeonweekends\MPesa\Transactions\Reversal;
use Codeonweekends\MPesa\Transactions\Status;
use phpseclib\Crypt\RSA as CryptRSA;

/**
 * Class APIContext
 * @package Codeonweekends\MPesa
 */
class APIContext implements APIContextInterface
{
    /**
     * @var string
     */
    protected $publicKey;

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var bool
     */
    protected $ssl;

    /**
     * @var int
     */
    protected $methodType;

    /**
     * @var string
     */
    protected $address;

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

    /**
     * APIContext constructor.
     *
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
    public function __construct($publicKey = '', $apiKey = '', $ssl = TRUE, $methodType = APIMethodType::GET, $address = '', $port = 80, $path = '', $headers = [], $parameters = [])
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
     * Creates a well formated URL
     *
     * @return string
     */
    public function getUrl(): string
    {
        $url = $this->address . ':' . $this->port . $this->path;
        $http = 'http://' . $url;
        $https = 'https://' . $url;

        return $this->ssl ? $https : $http;
    }

    /**
     * Generates a base64 encoded token
     */
    public function getToken(): string
    {
        if (!empty($this->publicKey) && !empty($this->apiKey))
        {
            $rsa = new CryptRSA();
            $decodedPublicKey = base64_decode($this->publicKey);
            $rsa->loadKey($decodedPublicKey);
            $rsa->setEncryptionMode(CryptRSA::ENCRYPTION_PKCS1);
            $cipherText = $rsa->encrypt($this->apiKey);
            $encodedApiKey = base64_encode($cipherText);

            return $encodedApiKey;
        }
        return '';
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
        return $this->publicKey;
    }

    /**
     * @param $value
     */
    public function setPublicKey($value): void
    {
        $this->publicKey = $value;
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * @param $value
     */
    public function setApiKey($value): void
    {
        $this->apiKey = $value;
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
        return $this->methodType;
    }

    /**
     * @param $value
     */
    public function setMethodType($value): void
    {
        $this->methodType = $value;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param $value
     */
    public function setAddress($value): void
    {
        $this->address = $value;
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
}
