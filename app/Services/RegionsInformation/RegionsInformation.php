<?php

namespace App\Services\RegionsInformation;

use App\Services\RegionsInformation\Api\HttpClient;
use App\Services\RegionsInformation\Models\Country;
use App\Services\RegionsInformation\Models\Region;

class RegionsInformation implements RegionsInformationInterface
{
    private HttpClient $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getRegions(Country $country): array
    {
        $regionsData = $this->httpClient->getResponse($country->getName());

        $regions = [];

        foreach ($regionsData['elements'] as $regionData) {
            $regions[] = new Region($regionData['tags']['name']);
        }

        return $regions;
    }
}
