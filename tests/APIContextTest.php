<?php
/**
 * @copyright 2019.
 * @author Amandio Khuta Nhamande <amandio16@gmail.com>
 * @license MIT
 */

namespace Tests;

use Codeonweekends\MPesa\APIContext;
use Codeonweekends\MPesa\APIMethodType;
use PHPUnit\Framework\TestCase;

class APIContextTest extends TestCase
{
    public function testValidToken(): void
    {
        $context = new APIContext();
        $context->setApiKey(getenv('MPESA_API_KEY'));
        $context->setPublicKey(getenv('MPESA_PUBLIC_KEY'));

        $this->assertNotNull($context->getToken());
    }

    public function testTokenIsEmpty(): void
    {
        $context = new APIContext();

        $this->assertEmpty($context->getToken());
    }

    public function testValidUrl (): void
    {
        $context = new APIContext('', '', false,APIMethodType::GET, getenv('MPESA_ADDRESS'), '');

        $this->assertNotNull($context->getUrl());
        $this->assertRegExp('/^(http):\/\/(.*):([0-9]*)(.*)/m', $context->getUrl());
    }

    public function testValidSslUrl (): void
    {
        $context = new APIContext('', '', true,APIMethodType::GET, getenv('MPESA_ADDRESS'), '');

        $this->assertNotNull($context->getUrl());
        $this->assertRegExp('/^(https):\/\/(.*):([0-9]*)(.*)/m', $context->getUrl());
    }
}