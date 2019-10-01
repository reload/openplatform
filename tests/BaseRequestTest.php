<?php

use DDB\OpenPlatform\OpenPlatform;
use DDB\OpenPlatform\Exceptions\InvalidPropertyException;
use DDB\OpenPlatform\Request\BaseRequest;
use DDB\OpenPlatform\Response\Response;
use DDB\OpenPlatform\Response\SearchResponse;
use PHPUnit\Framework\TestCase;

// phpcs:ignore PSR1.Classes.ClassDeclaration.MissingNamespace
class BaseRequestTest extends TestCase
{
    public function testSubclassesMustSetAPath()
    {

        $op = $this->prophesize(OpenPlatform::class);
        $this->expectException(RuntimeException::class);
        $req = new class($op->reveal()) extends BaseRequest {
            protected $properties = ['aProperty' => 'a_property'];
        };

        $req->aProperty = 'value';
        $req->execute();
    }

    public function testPropertyAccess()
    {

        $op = $this->prophesize(OpenPlatform::class);
        $op->request('/test', ['a_property' => 'value'], Response::class)->shouldBeCalled();

        $req = new class($op->reveal()) extends BaseRequest {
            protected $path = '/test';
            protected $properties = ['aProperty' => 'a_property', 'bProperty' => 'b_property'];
        };

        // Setting property.
        $req->aProperty = 'value';
        $req->bProperty = 'value2';
        // Getting property.
        $this->assertEquals('value', $req->aProperty);
        // Checking for existence.
        $this->assertTrue(isset($req->aProperty));
        // Should also work on undefined properties.
        $this->assertNotTrue(isset($req->cProperty));
        // Unset property.
        unset($req->bProperty);
        $this->assertNotTrue(isset($req->bProperty));

        $req->execute();
    }

    public function testInvalidProperties()
    {

        $op = $this->prophesize(OpenPlatform::class);

        $req = new class($op->reveal()) extends BaseRequest {
            protected $path = '/test';
            protected $properties = ['aProperty' => 'a_property'];
        };

        $this->expectException(InvalidPropertyException::class);
        $req->someProperty = 'value';
    }

    public function testExecute()
    {

        $op = $this->prophesize(OpenPlatform::class);
        $op->request('/test', [], Response::class)->shouldBeCalled();
        $req = new class($op->reveal()) extends BaseRequest {
            protected $path = '/test';
            protected $properties = [];
        };

        $req->execute();
    }

    public function testCustomResponse()
    {

        $op = $this->prophesize(OpenPlatform::class);
        $op->request('/test', ['a_property' => 'value'], SearchResponse::class)->shouldBeCalled();

        $req = new class($op->reveal()) extends BaseRequest {
            protected $path = '/test';
            protected $properties = ['aProperty' => 'a_property'];
            protected $responseClass = SearchResponse::class;
        };

        // Setting property.
        $req->aProperty = 'value';

        $res = $req->execute();
    }
}
