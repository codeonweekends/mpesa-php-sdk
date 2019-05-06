<?php
namespace Codeonweekends\MPesa;

use Codeonweekends\MPesa\Transactions\C2B;
use Codeonweekends\MPesa\Transactions\Reversal;
use Codeonweekends\MPesa\Transactions\Status;
use phpDocumentor\Reflection\Types\Array_;
use phpseclib\Crypt\RSA as CryptRSA;

/**
 * Class APIContext
 * @package Codeonweekends\MPesa
 */
class APIContext implements APIContextInterface
{
    /**
     * @var array
     */
    protected $config;

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
     * @param int $methodType
     * @param int $port
     * @param string $path
     * @param array $headers
     * @param array $parameters
     */
    public function __construct($methodType = APIMethodType::GET, $port = 80, $path = '', $headers = [], $parameters = [])
    {
        $this->config = require(__DIR__ . '/config.php');

        $this->methodType = $methodType;
        $this->headers = $headers;
        $this->parameters = $parameters;
        $this->port = $port;
        $this->path = $path;

        $this->address = $this->config['address'];
        $this->ssl = $this->config['ssl'];
        $this->publicKey = $this->config['public_key'];
        $this->apiKey = $this->config['api_key'];
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
            $key = "-----BEGIN PUBLIC KEY-----\n";
            $key .= wordwrap($this->publicKey, 60, "\n", true);
            $key .= "\n-----END PUBLIC KEY-----";
            $pk = openssl_get_publickey($key);
            openssl_public_encrypt($this->apiKey, $token, $pk, OPENSSL_PKCS1_PADDING);

            return base64_encode($token);
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
