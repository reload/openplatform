<?php

namespace DDB\OpenPlatform\Request;

use DDB\OpenPlatform\OpenPlatform;

/**
 * Perform a generic query.
 *
 * This can be used when there's no specific request class for a method.
 *
 * For further information, see https://openplatform.dbc.dk/v3/
 */
class GenericRequest extends BaseRequest
{
    public function __construct(OpenPlatform $openPlatform, string $path)
    {
        $this->path = $path;
        parent::__construct($openPlatform);
    }

    /**
     * Override checkProperty to allow any property.
     */
    protected function checkProperty($name): void
    {
        // Allow any property.
        if (!array_key_exists($name, $this->properties)) {
            $this->properties[$name] = $name;
            $this->data[$name] = null;
        }
    }
}
