<?php

namespace App\Services\GeoInfo;

use App\Services\GeoInfo\Api\HttpClient;
use App\Services\GeoInfo\Models\Polygon;
use App\Services\GeoInfo\Models\Query;

class GeoInfo implements GeoInfoInterface
{
    private HttpClient $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getPolygon(Query $query): Polygon
    {
        $response = $this->httpClient->getPolygonResponse($query->getQuery());

        return new Polygon(
            $response[0]['geojson']['coordinates'][0],
            $response[0]['geojson']['type']
        );
    }
}
