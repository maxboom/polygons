<?php

namespace App\Services\GeoInfo\Models;

class Polygon
{
    public const POLYGON_TYPE = 'Polygon';
    public const MULTIPOLYGON_TYPE = 'MultiPolygon';

    private array $points;
    private string $polygonType;

    public function __construct(array $points, string $polygonType)
    {
        $this->points = $points;
        $this->polygonType = $polygonType;
    }

    public function getPoints(): array
    {
        return $this->points;
    }

    public function getPolygonType(): string
    {
        return $this->polygonType;
    }
}
