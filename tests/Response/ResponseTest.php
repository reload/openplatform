<?php

namespace DDB\OpenPlatform\Response;

use DDB\OpenPlatform\Exceptions\RequestError;
use LogicException;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ResponseTest extends TestCase
{
    protected $response;

    public function setUp(): void
    {
        $data = [
            'statusCode' => 200,
            'data' => ['some' => 'data'],
        ];
        $this->response = $this->prophesize(ResponseInterface::class);
        $this->response->getContent(false)->willReturn(json_encode($data));
    }

    public function testResponseParsing()
    {
        $res = new Response($this->response->reveal());

        $this->assertEquals(['some' => 'data'], $res->get('data'));
    }

    public function testGettingUndefinedThrows()
    {
        $res = new Response($this->response->reveal());

        $this->expectException(LogicException::class);
        $res->get('unknown');
    }

    public function testHas()
    {
        $res = new Response($this->response->reveal());

        $this->assertTrue($res->has('data'));
        $this->assertNotTrue($res->has('unknown'));
    }

    public function testGetResponse()
    {
        $data = [
            'statusCode' => 200,
            'data' => ['some' => 'data'],
        ];
        $res = new Response($this->response->reveal());

        $this->assertEquals($data, $res->getResponse());
    }

    /**
     * Test that we use error_description if it's available.
     */
    public function testErrorDescription()
    {
        $data = [
            'statusCode' => 39,
            'error_description' => 'error message',
            'data' => ['some' => 'data'],
        ];
        $this->response = $this->prophesize(ResponseInterface::class);
        $this->response->getContent(false)->willReturn(json_encode($data));

        $res = new Response($this->response->reveal());

        $this->expectException(RequestError::class);
        $this->expectExceptionMessage('error message');
        $res->get('data');
    }

    /**
     * Test that we use error if it's available.
     */
    public function testError()
    {
        $data = [
            'statusCode' => 39,
            'error' => 'error message',
            'data' => ['some' => 'data'],
        ];
        $this->response = $this->prophesize(ResponseInterface::class);
        $this->response->getContent(false)->willReturn(json_encode($data));

        $res = new Response($this->response->reveal());

        $this->expectException(RequestError::class);
        $this->expectExceptionMessage('error message');
        $res->get('data');
    }

    /**
     * Test error message if no error descriptions was supplied in the
     * response.
     */
    public function testErrorWithoutMessage()
    {
        $data = [
            'statusCode' => 39,
            'data' => ['some' => 'data'],
        ];
        $this->response = $this->prophesize(ResponseInterface::class);
        $this->response->getContent(false)->willReturn(json_encode($data));

        $res = new Response($this->response->reveal());

        $this->expectException(RequestError::class);
        $this->expectExceptionMessage('Unknown error');
        $res->get('data');
    }
}
