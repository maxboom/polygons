<?php

namespace App\Services\Data;

use App\Services\Data\Models\UpdateQuery;

interface UpdateRegionsInterface
{
    public function updateRegions(UpdateQuery $updateQuery): void;
}
