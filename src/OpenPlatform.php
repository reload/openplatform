<?php

namespace DDB\OpenPlatform;

use DDB\OpenPlatform\Request\GenericRequest;
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

    /**
     * Create new client.
     *
     * @param string $token
     *   Token for authentication. See the readme for details on how to obtain one.
     * @param \Symfony\Contracts\HttpClient\HttpClientInterface $client
     *   HTTP client to use for requests.
     */
    public function __construct(string $token, HttpClientInterface $client = null)
    {
        $this->token = $token;
        $this->client = $client ?? HttpClient::create();
    }

    /**
     * Get a new search request.
     *
     * @param string $query
     *   CQL query to run.
     */
    public function search(string $query): SearchRequest
    {
        return new SearchRequest($this, $query);
    }

    /**
     * Get a new generic request.
     *
     * @param string $path
     *   The path of the resource.
     */
    public function generic(string $path): GenericRequest
    {
        return new GenericRequest($this, $path);
    }

    /**
     * Perform a request.
     *
     * @param string $path
     *   Path of the particular call. '/search' for instance.
     * @param array $payload
     *   Payload to send to the call, ie. the parameters.
     * @param string $class
     *   Response class. Will be instantiated with the call response.
     *
     * @return \DDB\OpenPlatform\Response\Response
     *   Instance of the class provided by the class parameter.
     */
    public function request(string $path, array $payload, string $class): Response
    {
        $payload['access_token'] = $this->token;

        $response = $this->client->request(
            'POST',
            'https://openplatform.dbc.dk/v3/' . ltrim($path, '/'),
            [
                'json' => $payload,
            ]
        );

        return new $class($response);
    }
}
