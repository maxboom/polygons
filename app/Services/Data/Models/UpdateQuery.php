<?php

namespace App\Services\Data\Models;

use App\Models\RefreshJob;

class UpdateQuery
{
    private const COUNTRY = 'Україна';
    private RefreshJob $refreshJob;

    public function __construct(RefreshJob $refreshJob)
    {
        $this->refreshJob = $refreshJob;
    }

    public function getCountry(): string
    {
        return self::COUNTRY;
    }

    public function getRefreshJob(): RefreshJob
    {
        return $this->refreshJob;
    }
}
