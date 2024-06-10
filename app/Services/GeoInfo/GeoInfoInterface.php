<?php

namespace App\Services\GeoInfo;

use App\Services\GeoInfo\Models\Polygon;
use App\Services\GeoInfo\Models\Query;

interface GeoInfoInterface
{
    public function getPolygon(Query $query): Polygon;
}
