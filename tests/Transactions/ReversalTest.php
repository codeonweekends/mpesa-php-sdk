<?php
/**
 * @copyright 2019.
 * @author Amandio Khuta Nhamande <amandio16@gmail.com>
 * @license MIT
 *
 */

namespace Tests\Transactions;

use Codeonweekends\MPesa\Context;
use Codeonweekends\MPesa\Response;
use Codeonweekends\MPesa\Transactions\Reversal;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;

class ReversalTest extends TestCase
{
    public $context;
    public $reversal;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->context = new Context();
        $this->reversal = new Reversal(10, '49XCDF6', strtoupper(Str::random(6)));
        $this->reversal->setApiContext($this->context);
    }

    public function testGetApiContext()
    {
        $this->assertInstanceOf(Context::class, $this->reversal->getApiContext());
    }

    /**
     * @throws \Exception
     */
    public function testGetResponse()
    {
        $this->reversal->send();

        $this->assertInstanceOf(Response::class, $this->reversal->getResponse());
    }
}
