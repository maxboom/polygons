<?php

namespace App\Services\Data;

use App\Jobs\RefreshPolygonsProcess;
use App\Models\RefreshJob;
use App\Models\Region as BaseRegion;
use App\Services\Data\Models\RefreshOptions;
use App\Services\Data\Models\SearchQuery;
use App\Services\Data\Models\SearchResponse;
use App\Services\Data\Models\UpdateQuery;
use App\Services\GeoInfo\GeoInfoInterface;
use App\Services\GeoInfo\Models\Polygon;
use App\Services\GeoInfo\Models\Query;
use App\Services\RegionsInformation\Models\Country;
use App\Services\RegionsInformation\Models\Region;
use App\Services\RegionsInformation\RegionsInformationInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DataService implements
    SearchDataInterface,
    RefreshDataInterface,
    PurgeDataInterface,
    UpdateRegionsInterface
{
    private RegionsInformationInterface $regionsInformation;
    private GeoInfoInterface $geoInfo;

    public function __construct(
        RegionsInformationInterface $regionsInformation,
        GeoInfoInterface $geoInfo,
    )
    {
        $this->regionsInformation = $regionsInformation;
        $this->geoInfo = $geoInfo;
    }

    public function purge(): void
    {
        BaseRegion::query()->truncate();

        Cache::flush();
    }

    public function refresh(RefreshOptions $refreshOptions): void
    {
        $carbonDelay = Carbon::now()->addSeconds($refreshOptions->getDelay());

        $refreshJob = RefreshJob::create([
            'sheduled_for_ts' => $carbonDelay,
            'status' => RefreshJob::STATUS_CREATED
        ]);

        RefreshPolygonsProcess::dispatch($refreshJob)->delay($carbonDelay);
    }

    public function search(SearchQuery $searchQuery): ?SearchResponse
    {
        $longitude = $searchQuery->getLongitude();
        $latitude = $searchQuery->getLatitude();
        $cacheKey = "location_{$longitude}_{$latitude}";
        $cacheExists = Cache::has($cacheKey);

        $region = Cache::rememberForever($cacheKey, function () use ($longitude, $latitude) {
            return BaseRegion::whereRaw(
                'ST_Contains(geom, ST_GeomFromText(?))',
                "POINT($longitude $latitude)"
            )->first();
        });

        return new SearchResponse($region, $cacheExists);
    }

    public function updateRegions(UpdateQuery $updateQuery): void
    {
        $regions = $this->regionsInformation->getRegions(new Country($updateQuery->getCountry()));

        foreach ($regions as $region) {
            $polygon = $this->geoInfo->getPolygon(new Query($region->getName()));

            $this->persistPolygon($updateQuery->getRefreshJob(), $region, $polygon);
        }

        $this->clearFinishedPolygons();
    }

    private function persistPolygon(RefreshJob $refreshJob, Region $region, Polygon $polygon): void
    {
        if (Polygon::POLYGON_TYPE === $polygon->getPolygonType()) {
            $this->persistSinglePolygon($refreshJob, $region, $polygon->getPoints());

            return;
        }

        if (Polygon::MULTIPOLYGON_TYPE !== $polygon->getPolygonType()) {
            return;
        }

        foreach ($polygon->getPoints() as $polygon) {
            $this->persistSinglePolygon($refreshJob, $region, $polygon);
        }
    }

    private function persistSinglePolygon(RefreshJob $refreshJob, Region $region, array $points): void
    {
        Log::debug( 'Region:' . $region->getName());
        Log::debug( 'Polygon:' . json_encode($points));

        $polygonWKT = 'POLYGON((' . implode(',', array_map(function ($point) {
                return implode(' ', $point);
            }, $points)) . '))';

        DB::table('regions')->insert([
            'name' => $region->getName(),
            'geom' => DB::raw("ST_GeomFromText('$polygonWKT')"),
            'job_id' => $refreshJob->id
        ]);
    }

    private function clearFinishedPolygons(): void
    {
        BaseRegion::whereHas('job', function ($query) {
            $query->where(['status' => RefreshJob::STATUS_FINISHED]);
        })->delete();

        Cache::flush();
    }
}
