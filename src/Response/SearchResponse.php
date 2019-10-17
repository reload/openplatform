<?php

namespace DDB\OpenPlatform\Response;

class SearchResponse extends Response
{
    /**
     * Get response materials.
     */
    public function getData()
    {
        return $this->get('data');
    }

    /**
     * Get hit count.
     */
    public function getHitCount(): int
    {
        return (int) $this->get('hitCount');
    }

    /**
     * Whether there's more results than returned.
     */
    public function getMore(): bool
    {
        return (bool) $this->get('more');
    }
}
