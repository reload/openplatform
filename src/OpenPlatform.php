<?php

namespace DDB\OpenPlatform;

use DDB\OpenPlatform\Request\SearchRequest;
use DDB\OpenPlatform\Response\Response;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OpenPlatform
{
    /**
     * HTTP client.
     *
     * @var \Symfony\Contracts\HttpClient\HttpClientInterface
     */
    protected $client;

    /**
     * OpenPlatform access token.
     *
     * @var string
     */
    protected $token;

    public function __construct($token, HttpClientInterface $client = null)
    {
        $this->token = $token;

        if (!$client) {
            $client = HttpClient::create();
        }
        $this->client = $client;
    }

    public function searchRequest()
    {
        return new SearchRequest($this);
    }

    public function request($path, $payload)
    {
        $payload['access_token'] = $this->token;

        $response = $this->client->request(
            'POST',
            'https://openplatform.dbc.dk/v3/' . ltrim($path, '/'),
            [
                //'headers' => ['Content-Type' => 'Application/json'],
                'json' => $payload,
            ]
        );

        return new Response($response);
    }
}
