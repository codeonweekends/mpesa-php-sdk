<?php

use PHPUnit\Framework\TestCase;
use Codeonweekends\MPesa\MPesa;

class MPesaTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testC2b ()
    {
        $mpesa = new MPesa();

        $response = $mpesa->c2b(substr(sha1(time()), 0, 6), 12, '258848914919', getenv('MPESA_SERVICE_PROVIDER_CODE'), 'T' . rand(6000, 10000));

        $this->assertIsObject($response);
        $this->assertObjectHasAttribute('output_ConversationID', $response);
        $this->assertObjectHasAttribute('output_ResponseCode', $response);
        $this->assertObjectHasAttribute('output_TransactionID', $response);
        $this->assertObjectHasAttribute('output_ThirdPartyReference', $response);
        $this->assertObjectHasAttribute('output_ResponseDesc', $response);


        return $response;
    }

    /**
     * @depends testC2b
     * @throws Exception
     */
    public function testC2bTransactionStatus ($response)
    {
        $mpesa = new MPesa();

        $r = $mpesa->transactionStatus ($response->output_ThirdPartyReference, $response->output_ConversationID, '171717');

        $this->assertObjectHasAttribute('output_ResponseCode', $r);
        if ($r->output_ResponseCode === 'INS-0') {
            $this->assertObjectHasAttribute('output_ResponseDesc', $r);
            $this->assertObjectHasAttribute('output_ConversationID', $r);
            $this->assertObjectHasAttribute('output_ResponseTransactionStatus', $r);
            $this->assertObjectHasAttribute('output_ThirdPartyReference', $r);
        }

        return $response;
    }

    /**
     * @depends testC2b
     * @depends testC2bTransactionStatus
     * @throws Exception
     */
    public function testTransactionReversal ($response, $success)
    {
        $this->assertEquals('INS-0', $response->output_ResponseCode);
        $this->assertNotEmpty($response->output_ConversationID);
        $this->assertNotEmpty($response->output_TransactionID);

        $mpesa = new MPesa();

        $r = $mpesa->transactionReversal(10, getenv('MPESA_SERVICE_PROVIDER_CODE'), $response->output_TransactionID, getenv('MPESA_SECURITY_CREDENTIAL'), getenv('MPESA_INITIATOR_IDENTIFIER'));

        return $r;
    }
}


