<?php

namespace DDB\OpenPlatform\Response;

use DDB\OpenPlatform\Exceptions\RequestError;
use DDB\OpenPlatform\OpenPlatform;
use LogicException;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * @property int $statusCode
 *   The response status code.
 * @property array $data
 *   The data requested.
 * @property string[] $errors
 *   Array of any errors.
 * @property array $timings
 *   Timing information, if requested.
 */
class Response
{
    protected $responseData;

    /**
     * @var \Symfony\Contracts\HttpClient\ResponseInterface
     */
    protected $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * Get a response property.
     */
    public function get(string $name)
    {
        $this->ensureData();
        if (!array_key_exists($name, $this->responseData)) {
            throw new LogicException('Unknow property.');
        }
        return $this->responseData[$name];
    }

    /**
     * Return whether a given property exists.
     */
    public function has(string $name): bool
    {
        $this->ensureData();
        return isset($this->responseData[$name]);
    }

    /**
     * Return the full response.
     */
    public function getResponse(): array
    {
        $this->ensureData();
        return $this->responseData;
    }

    /**
     * Ensure that responseData property is populated.
     */
    protected function ensureData(): void
    {
        if (is_null($this->responseData)) {
            // We'll ignore the HTTP status and go by the statusCode provided by the service.
            $this->responseData = json_decode($this->response->getContent(false), true);
            if (!isset($this->responseData['statusCode']) || $this->responseData['statusCode'] != 200) {
                $message = $this->responseData['error_description'] ?? $this->responseData['error'] ?? 'Unknown error';
                throw new RequestError($message);
            }
        }
    }
}
