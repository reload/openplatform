<?php

namespace DDB\OpenPlatform\Request;

/**
 * Perform a search query.
 *
 * @property array $fields
 *   Fields to request per material.
 * @property string $query
 *   The query to run. Required.
 * @property int $offset
 *   Starting offset in result.
 * @property int $limit
 *   Maximum number of results returned.
 * @property string $sort
 *   Sort order.
 * @property string $profile
 *   Search profile.
 *
 * For further information, see the /search call at
 * https://openplatform.dbc.dk/v3/
 */
class SearchRequest extends BaseRequest
{
    protected $path = '/search';
    protected $properties = [
        'fields' => 'fields',
        'query' => 'q',
        'offset' => 'offset',
        'limit' => 'limit',
        'sort' => 'sort',
        'profile' => 'profile',
    ];
}
