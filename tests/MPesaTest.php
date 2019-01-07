<?php

use PHPUnit\Framework\TestCase;

class MPesaTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testC2b ()
    {
        $mpesa = new Codeonweekends\MPesa\MPesa();
        $mpesa->getApiContext()->setPublicKey(getenv('MPESA_PUBLIC_KEY'));
        $mpesa->getApiContext()->setApiKey(getenv('MPESA_API_KEY'));

        $response = $mpesa->c2b(sha1(time()), 1, getenv('MPESA_CUSTOMER_MSISDN'), getenv('MPESA_SERVICE_PROVIDER_CODE'), 'PTEST' . rand(0, 100));

        $this->assertIsObject($response);
        $this->assertObjectHasAttribute('output_ConversationID', $response);
        $this->assertObjectHasAttribute('output_ResponseCode', $response);
        $this->assertObjectHasAttribute('output_TransactionID', $response);
        $this->assertObjectHasAttribute('output_ResponseDesc', $response);

        return $response;
    }

    /**
     * @depends testC2b
     */
    public function testTransactionStatus ($response)
    {
        $this->assertEquals('INS-0', $response->output_ResponseCode);
    }

    /**
     * @depends testC2b
     * @depends testC2bSuccess
     * @throws Exception
     */
    public function testTransactionReversal ($response, $success)
    {
        $this->assertEquals('INS-0', $response->output_ResponseCode);
        $this->assertNotEmpty($response->output_ConversationID);
        $this->assertNotEmpty($response->output_TransactionID);

        $mpesa = new Codeonweekends\MPesa\MPesa();
        $mpesa->getApiContext()->setPublicKey(getenv('MPESA_PUBLIC_KEY'));
        $mpesa->getApiContext()->setApiKey(getenv('MPESA_API_KEY'));

        $r = $mpesa->transactionReversal(10, getenv('MPESA_SERVICE_PROVIDER_CODE'), $response->output_TransactionID, getenv('MPESA_SECURITY_CREDENTIAL'), getenv('MPESA_INITIATOR_IDENTIFIER'));

        $this->assertObjectHasAttribute('output_ResponseCode', $r);
        $this->assertEquals('INS-0', $r->output_ResponseCode);

        return $r;
    }
}
