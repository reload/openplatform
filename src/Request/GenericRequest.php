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
}
