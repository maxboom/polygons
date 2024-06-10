<?php

namespace App\Services\Data\Models;

class RefreshOptions
{
    private int $delay;

    public function __construct(int $delay)
    {
        $this->delay = $delay;
    }

    public function getDelay(): int
    {
        return $this->delay;
    }
}
