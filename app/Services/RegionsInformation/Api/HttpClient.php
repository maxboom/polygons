<?php

namespace App\Services\RegionsInformation\Api;

use GuzzleHttp\ClientInterface;

class HttpClient
{
    private const API_ENDPOINT = 'http://overpass-api.de/api/interpreter';

    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function getResponse(string $countryName): array
    {
        $response = $this->client->request('GET', self::API_ENDPOINT, [
            'body' => '[out:json];
        area["name"="' . $countryName . '"]["boundary"="administrative"]["admin_level"="2"]->.country;
        (rel(area.country)["boundary"="administrative"]["admin_level"="4"];
        );
        out body;'
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
