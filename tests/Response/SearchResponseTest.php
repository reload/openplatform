<?php

namespace DDB\OpenPlatform\Response;

use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\ResponseInterface;

class SearchResponseTest extends TestCase
{
    protected $response;

    public function setUp(): void
    {
        $data = [
            'statusCode' => 200,
            'data' => ['some' => 'data'],
            'hitCount' => 42,
            'more' => true,
        ];
        $this->response = $this->prophesize(ResponseInterface::class);
        $this->response->getContent(false)->willReturn(json_encode($data));
    }

    public function testResponseProperties()
    {
        $res = new SearchResponse($this->response->reveal());

        $this->assertEquals(['some' => 'data'], $res->getMaterials());
        $this->assertEquals(42, $res->getHitCount());
        $this->assertTrue($res->getMore());
    }
}
