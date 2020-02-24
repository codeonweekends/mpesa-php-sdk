<?php

use PHPUnit\Framework\TestCase;
use Codeonweekends\MPesa\MPesa;

class MPesaTest extends TestCase
{
    public $mpesa;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->mpesa= new MPesa();
        $this->mpesa->getApiContext()->setPublicKey(getenv('MPESA_PUBLIC_KEY'));
        $this->mpesa->getApiContext()->setApiKey(getenv('MPESA_API_KEY'));
    }

    /**
     * @throws Exception
     */
    public function testC2b ()
    {
        $response = $this->mpesa->c2b('T' . rand(6000, 10000), 1100, '258848914919', substr(sha1(time()), 0, 6), getenv('MPESA_SERVICE_PROVIDER_CODE'));

        $this->assertIsObject($response);
        $this->assertObjectHasAttribute('output_ConversationID', $response);
        $this->assertObjectHasAttribute('output_ResponseCode', $response);
        $this->assertObjectHasAttribute('output_ThirdPartyReference', $response);
        $this->assertObjectHasAttribute('output_ResponseDesc', $response);

        return $response;
    }

    /**
     * @depends testC2b
     * @throws Exception
     */
    public function testC2bTransactionIsCompletedWithSuccess($data)
    {
        $this->assertEquals('INS-0', $data->output_ResponseCode);

        return $data;
    }

    /**
     * @depends testC2b
     * @throws Exception
     */
    public function testC2bTransactionStatus ($response)
    {
        $r = $this->mpesa->transactionStatus ($response->output_ThirdPartyReference, $response->output_ConversationID, getenv('MPESA_SERVICE_PROVIDER_CODE'));

        $this->assertObjectHasAttribute('output_ResponseCode', $r);
        if ($r->output_ResponseCode === 'INS-0') {
            $this->assertObjectHasAttribute('output_ResponseDesc', $r);
            $this->assertObjectHasAttribute('output_ConversationID', $r);
            $this->assertObjectHasAttribute('output_ThirdPartyReference', $r);
        }

        return $response;
    }

//    /**
//     * @depends testC2bTransactionIsCompletedWithSuccess
//     * @throws Exception
//     */
//    public function testTransactionReversal ($response)
//    {
//        $this->assertEquals('INS-0', $response->output_ResponseCode);
//        $this->assertNotEmpty($response->output_ConversationID);
//        $this->assertNotEmpty($response->output_TransactionID);
//
//        $r = $this->mpesa->transactionReversal(10, getenv('MPESA_SERVICE_PROVIDER_CODE'), $response->output_TransactionID, getenv('MPESA_SECURITY_CREDENTIAL'), getenv('MPESA_INITIATOR_IDENTIFIER'));
//
//        return $r;
//    }
}


