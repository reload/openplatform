<?php

namespace DDB\OpenPlatform\Response;

use DDB\OpenPlatform\Exceptions\RequestError;
use DDB\OpenPlatform\OpenPlatform;
use RuntimeException;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * @property array $data
 */
class Response
{
    protected $data;

    /**
     * @var \Symfony\Contracts\HttpClient\ResponseInterface
     */
    protected $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function __set(string $name, $value) : void
    {
        throw new RuntimeException('Cannot set proporties on responses.');
    }

    public function __get(string $name)
    {
        $this->ensureData();
        if (!array_key_exists($name, $this->data)) {
            throw new RuntimeException('Unknow property.');
        }
        return $this->data[$name];
    }

    public function __isset(string $name) : bool
    {
        $this->ensureData();
        return isset($this->data[$name]);
    }

    public function __unset(string $name) : void
    {
        throw new RuntimeException('Cannot set proporties on responses.');
    }

    /**
     * Ensure that data property is populated.
     */
    protected function ensureData() : void
    {
        if (is_null($this->data)) {
            // We'll  ignore the HTTP status and go by the statusCode provided by the service.
            $this->data = json_decode($this->response->getContent(false), true);
            if (!isset($this->data['statusCode']) || $this->data['statusCode'] != 200) {
                $message = $this->data['error_description'] ?? $this->data['error'] ?? 'Unknown error';
                throw new RequestError($message);
            }
        }
    }

}
