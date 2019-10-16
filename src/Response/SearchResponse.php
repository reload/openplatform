<?php

namespace DDB\OpenPlatform\Response;

/**
 * @property array $data
 *   Array of materials.
 * @property int $hitCount
 *   Total number of matching materials.
 * @property bool $more
 *   Whether there are more pages.
 */
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
