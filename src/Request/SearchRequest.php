<?php

namespace DDB\OpenPlatform\Request;

use DDB\OpenPlatform\OpenPlatform;
use DDB\OpenPlatform\Response\SearchResponse;
use LogicException;

/**
 * Perform a search query.
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
    protected $responseClass = SearchResponse::class;

    public function __construct(OpenPlatform $openplatform, string $query)
    {
        parent::__construct($openplatform);
        $this->data['q'] = $query;
    }

    /**
     * Request fields in response.
     *
     * A list of possible fields can be found at
     * https://raw.githubusercontent.com/DBCDK/serviceprovider/master/doc/work-context.jsonld
     */
    public function withFields(array $fields)
    {
        return $this->with('fields', $fields);
    }

    /**
     * Set starting offwith in result.
     */
    public function withOffset(int $offset)
    {
        return $this->with('offset', $offset);
    }

    /**
     * Set maximum number of results returned.
     */
    public function withLimit(int $limit)
    {
        return $this->with('limit', $limit);
    }

    /**
     * Set sort order.
     */
    public function withSort(string $sort)
    {
        return $this->with('sort', $sort);
    }

    /**
     * Set search profile.
     */
    public function withProfile(string $profile)
    {
        return $this->with('profile', $profile);
    }
}
