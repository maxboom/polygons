<?php

namespace App\Services\Data;

use App\Services\Data\Models\SearchQuery;
use App\Services\Data\Models\SearchResponse;

interface SearchDataInterface
{
    public function search(SearchQuery $searchQuery): ?SearchResponse;
}
