<?php

use DDB\OpenPlatform\OpenPlatform;
use DDB\OpenPlatform\Request\GenericRequest;
use DDB\OpenPlatform\Response\Response;
use PHPUnit\Framework\TestCase;

// phpcs:ignore PSR1.Classes.ClassDeclaration.MissingNamespace
class GenericRequestTest extends TestCase
{

    public function testGenericRequest()
    {

        $op = $this->prophesize(OpenPlatform::class);
        $op->request('/test', ['aProperty' => 'value'], Response::class)->shouldBeCalled();

        $req = new GenericRequest($op->reveal(), '/test');

        $req->aProperty = 'value';
        $req->execute();
    }

}
