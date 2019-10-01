<?php

use DDB\OpenPlatform\Exceptions\RequestError;
use DDB\OpenPlatform\Response\Response;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\ResponseInterface;

// phpcs:ignore PSR1.Classes.ClassDeclaration.MissingNamespace
class ResponseTest extends TestCase
{

    public function setUp() : void
    {
        $data = [
            'statusCode' => 200,
            'data' => ['some' => 'data'],
        ];
        $this->response = $this->prophesize(ResponseInterface::class);
        $this->response->getContent()->willReturn(json_encode($data));
    }

    public function testResponseParsing()
    {
        $res = new Response($this->response->reveal());

        $this->assertEquals(['some' => 'data'], $res->data);
    }

    public function testSettingThrows()
    {
        $res = new Response($this->response->reveal());

        $this->expectException(RuntimeException::class);
        $res->data = 'test';
    }

    public function testUnsettingThrows()
    {
        $res = new Response($this->response->reveal());

        $this->expectException(RuntimeException::class);
        unset($res->data);
    }

    public function testGettingUndefinedThrows()
    {
        $res = new Response($this->response->reveal());

        $this->expectException(RuntimeException::class);
        $res->unknown;
    }

    public function testIsset()
    {
        $res = new Response($this->response->reveal());

        $this->assertTrue(isset($res->data));
        $this->assertNotTrue(isset($res->nodata));
    }

    public function testErrorDescription()
    {
        $data = [
            'statusCode' => 39,
            'error_description' => 'error message',
            'data' => ['some' => 'data'],
        ];
        $this->response = $this->prophesize(ResponseInterface::class);
        $this->response->getContent()->willReturn(json_encode($data));

        $res = new Response($this->response->reveal());

        $this->expectException(RequestError::class);
        $this->expectExceptionMessage('error message');
        $res->data;
    }

    public function testError()
    {
        $data = [
            'statusCode' => 39,
            'error' => 'error message',
            'data' => ['some' => 'data'],
        ];
        $this->response = $this->prophesize(ResponseInterface::class);
        $this->response->getContent()->willReturn(json_encode($data));

        $res = new Response($this->response->reveal());

        $this->expectException(RequestError::class);
        $this->expectExceptionMessage('error message');
        $res->data;
    }

    public function testErrorWithoutMessage()
    {
        $data = [
            'statusCode' => 39,
            'data' => ['some' => 'data'],
        ];
        $this->response = $this->prophesize(ResponseInterface::class);
        $this->response->getContent()->willReturn(json_encode($data));

        $res = new Response($this->response->reveal());

        $this->expectException(RequestError::class);
        $this->expectExceptionMessage('Unknown error');
        $res->data;
    }

}
