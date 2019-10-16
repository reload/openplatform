<?php

namespace DDB\OpenPlatform\Request;

use DDB\OpenPlatform\OpenPlatform;
use DDB\OpenPlatform\Response\Response;
use PHPUnit\Framework\TestCase;

class GenericRequestTest extends TestCase
{
    public function testGenericRequest()
    {
        $op = $this->prophesize(OpenPlatform::class);
        $op->request('/test', ['aProperty' => 'value'], Response::class)->shouldBeCalled();

        $req = new GenericRequest($op->reveal(), '/test');

        $req = $req->with('aProperty', 'value');
        $req->execute();
    }
}
