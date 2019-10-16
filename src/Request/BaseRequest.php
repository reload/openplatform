<?php

namespace DDB\OpenPlatform\Request;

use DDB\OpenPlatform\OpenPlatform;
use DDB\OpenPlatform\Response\Response;
use RuntimeException;

abstract class BaseRequest
{
    /**
     * OpenPlatform client.
     *
     * @var \DDB\OpenPlatform\OpenPlatform
     */
    protected $openPlatform;

    /**
     * API path of request.
     *
     * @var string
     */
    protected $path;

    /**
     * Class of response
     *
     * @var string
     */
    protected $responseClass = Response::class;

    /**
     * Request parameters.
     */
    protected $data = [];

    public function __construct(OpenPlatform $openPlatform)
    {
        $this->openPlatform = $openPlatform;
        if (!isset($this->path)) {
            throw new RuntimeException('No path for request.');
        }
    }

    public function execute()
    {
        return $this->openPlatform->request($this->path, $this->data, $this->responseClass);
    }

    /**
     * Set request parameter.
     *
     * @param string $name
     *   Parameter name.
     * @param mixed $value
     *   Parameter value.
     */
    public function set($name, $value)
    {
        $this->data[$name] = $value;
    }
}
