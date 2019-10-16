<?php

namespace DDB\OpenPlatform\Request;

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

    public function execute()
    {
        if (!isset($this->data['q'])) {
            throw new LogicException('query parameter required for search');
        }

        return parent::execute();
    }

    /**
     * Set the query to run.
     *
     * Required.
     */
    public function setQuery(string $query)
    {
        $this->set('q', $query);
    }

    /**
     * Set fields to request per material.
     */
    public function setFields(array $fields)
    {
        $this->set('fields', $fields);
    }

    /**
     * Set starting offset in result.
     */
    public function setOffset(int $offset)
    {
        $this->set('offset', $offset);
    }

    /**
     * Set maximum number of results returned.
     */
    public function setLimit(int $limit)
    {
        $this->set('limit', $limit);
    }

    /**
     * Set sort order.
     */
    public function setSort(string $sort)
    {
        $this->set('sort', $sort);
    }

    /**
     * Set search profile.
     */
    public function setProfile(string $profile)
    {
        $this->set('profile', $profile);
    }
}
