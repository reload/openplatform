<?php

namespace DDB\OpenPlatform\Request;

use DDB\OpenPlatform\Response\SearchResponse;

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
    public const SORT_NONE = 'rank_none';
    public const SORT_RANDOM = 'random';
    public const SORT_TITLE = 'rank_title';
    public const SORT_GENERAL = 'rank_general';
    public const SORT_MAIN_TITLE = 'rank_main_title';
    public const SORT_SUBJECT = 'rank_subject';
    public const SORT_TITLE_CREATOR = 'rank_verification';
    public const SORT_CREATOR = 'rank_creator';
    public const SORT_DATE_DESC = 'date_descending';
    public const SORT_ARTICLE_DATE_DESC = 'article_date_descending';
    public const SORT_ACQUISITION_DATE_DESC = 'acquisitionDate_descending';

    protected $path = '/search';
    protected $properties = [
        'fields' => 'fields',
        'query' => 'q',
        'offset' => 'offset',
        'limit' => 'limit',
        'sort' => 'sort',
        'profile' => 'profile',
    ];
    protected $responseClass = SearchResponse::class;
}
