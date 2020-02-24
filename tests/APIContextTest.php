<?php
/**
 * @copyright 2019.
 * @author Amandio Khuta Nhamande <amandio16@gmail.com>
 * @license MIT
 *
 */

use Codeonweekends\MPesa\Context;
use PHPUnit\Framework\TestCase;

class APIContextTest extends TestCase
{
    public $context;

    public function __construct()
    {
        parent::__construct();
        $this->context = new Context();
        $this->context->addHeader("Origin", "*");
        $this->context->setPublicKey(getenv('MPESA_PUBLIC_KEY'));
        $this->context->setApiKey(getenv('MPESA_API_KEY'));
    }

    public function testGetApiKey()
    {
        $this->assertNotEmpty($this->context->getApiKey());
    }

    public function testGetPublicKey()
    {
        $this->assertNotEmpty($this->context->getPublicKey());
    }

    public function testGetUrl()
    {
        $this->assertNotEmpty($this->context->getUrl());
    }

    public function testGetToken()
    {
        $this->assertNotNull($this->context->getToken());
    }
}
