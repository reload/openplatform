<?php

namespace DDB\OpenPlatform\Request;

use DDB\OpenPlatform\OpenPlatform;
use DDB\OpenPlatform\Response\Response;
use DDB\OpenPlatform\Response\SearchResponse;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class BaseRequestTest extends TestCase
{
    public function testSubclassesMustSetAPath()
    {
        $op = $this->prophesize(OpenPlatform::class);
        $this->expectException(RuntimeException::class);
        $req = new class ($op->reveal()) extends BaseRequest {
        };

        $req->execute();
    }

    public function testWithReturnsNewInstance()
    {
        $op = $this->prophesize(OpenPlatform::class);
        $op->request('/test', ['a_property' => 'value'], Response::class)
            ->willReturn($this->prophesize(Response::class))
            ->shouldBeCalled();

        $req = new class ($op->reveal()) extends BaseRequest {
            protected $path = '/test';
        };

        $req2 = $req->with('a_property', 'value');

        $this->assertNotEquals($req, $req2);
        $res = $req2->execute();
    }

    public function testExecute()
    {
        $op = $this->prophesize(OpenPlatform::class);
        $op->request('/test', [], Response::class)
            ->willReturn($this->prophesize(Response::class))
            ->shouldBeCalled();
        $req = new class ($op->reveal()) extends BaseRequest {
            protected $path = '/test';
            protected $properties = [];
        };

        $req->execute();
    }

    public function testCustomResponse()
    {
        $op = $this->prophesize(OpenPlatform::class);
        $op->request('/test', ['aProperty' => 'value'], SearchResponse::class)
            ->willReturn($this->prophesize(SearchResponse::class))
            ->shouldBeCalled();

        $req = new class ($op->reveal()) extends BaseRequest {
            protected $path = '/test';
            protected $responseClass = SearchResponse::class;
        };

        // Setting property.
        $req = $req->with('aProperty', 'value');

        $res = $req->execute();
    }
}
