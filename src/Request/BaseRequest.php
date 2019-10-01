<?php

namespace DDB\OpenPlatform\Request;

use DDB\OpenPlatform\Exceptions\InvalidPropertyException;
use DDB\OpenPlatform\OpenPlatform;
use RuntimeException;

abstract class BaseRequest
{
    /**
     * OpenPlatform client.
     *
     * @var \DDB\OpenPlatform\OpenPlatform
     */
    protected $openPlatform;

    protected $path;
    protected $properties = [];

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
        // Remove empty values and adjust keys according to $this->properties.
        // This ought to be easier functionally, but you try to come up with
        // something that's also readable.
        $data = [];
        foreach ($this->data as $key => $val) {
            if (isset($val)) {
                $data[$this->properties[$key]] = $val;
            }
        }

        return $this->openPlatform->request($this->path, $data);
    }

    public function __set(string $name, $value) : void
    {
        $this->checkProperty($name);
        $this->data[$name] = $value;
    }

    public function __get(string $name)
    {
        $this->checkProperty($name);
        return $this->data[$name];
    }

    public function __isset(string $name) : bool
    {
        return isset($this->data[$name]);
    }

    public function __unset(string $name) : void
    {
        $this->checkProperty($name);
        $this->data[$name] = null;
    }

    protected function checkProperty($name)
    {
        if (!array_key_exists($name, $this->properties)) {
            throw new InvalidPropertyException();
        }
    }
}
