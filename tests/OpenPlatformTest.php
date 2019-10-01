<?php

use DDB\OpenPlatform\OpenPlatform;
use DDB\OpenPlatform\Request\GenericRequest;
use DDB\OpenPlatform\Request\SearchRequest;
use DDB\OpenPlatform\Response\Response;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

// phpcs:ignore PSR1.Classes.ClassDeclaration.MissingNamespace
class OpenPlatformTest extends TestCase
{

    /**
     * Test that the token is added to requests.
     */
    public function testTokenPassing()
    {
        $client = $this->prophesize(HttpClientInterface::class);
        $response = $this->prophesize(ResponseInterface::class);

        $client->request(
            'POST',
            'https://openplatform.dbc.dk/v3/test',
            ['json' => ['the' => 'data', 'access_token' => 'the token']]
        )->willReturn($response)->shouldBeCalled();

        $op = new OpenPlatform('the token', $client->reveal());
        $op->request('/test', ['the' => 'data'], Response::class);
    }

    /**
     * Test that it returns proper requests.
     */
    public function testRequestGetters()
    {
        $client = $this->prophesize(HttpClientInterface::class);

        $op = new OpenPlatform('the token', $client->reveal());
        $this->assertInstanceOf(SearchRequest::class, $op->searchRequest());
        $this->assertInstanceOf(GenericRequest::class, $op->genericRequest('/test'));
    }
}
