<?php

namespace App\Services\Data;

use App\Services\Data\Models\RefreshOptions;

interface RefreshDataInterface
{
    public function refresh(RefreshOptions $refreshOptions): void;
}
