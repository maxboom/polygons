<?php

namespace App\Services\Data\Models;

use App\Models\Region;

class SearchResponse
{
    private ?Region $region;
    private bool $usedCache;

    public function __construct(?Region $region, bool $usedCache)
    {
        $this->region = $region;
        $this->usedCache = $usedCache;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function isUsedCache(): bool
    {
        return $this->usedCache;
    }
}
