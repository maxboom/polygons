<?php

namespace App\Services\RegionsInformation;

use App\Services\RegionsInformation\Models\Country;
use App\Services\RegionsInformation\Models\Region;

interface RegionsInformationInterface
{
    /**
     * @return Region[]
     */
    public function getRegions(Country $country): array;
}
