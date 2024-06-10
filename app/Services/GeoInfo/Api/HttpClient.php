<?php

namespace App\Services\GeoInfo\Api;

use GuzzleHttp\ClientInterface;

class HttpClient
{
    private const API_ENDPOINT = 'https://nominatim.openstreetmap.org/search';

    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function getPolygonResponse(string $query): array
    {
        return $this->getResponse([
            'format' => 'json',
            'q' => $query,
            'polygon_geojson' => 1
        ]);
    }

    private function getResponse(array $params): array
    {
        $response = $this->client->request('GET', self::API_ENDPOINT, [
            'query' => $params
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
