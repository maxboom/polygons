<?php

namespace App\Jobs;

use App\Models\RefreshJob;
use App\Models\Region as BaseRegion;
use App\Services\Data\Models\UpdateQuery;
use App\Services\Data\UpdateRegionsInterface;
use App\Services\GeoInfo\GeoInfoInterface;
use App\Services\GeoInfo\Models\Polygon;
use App\Services\GeoInfo\Models\Query;
use App\Services\RegionsInformation\Models\Country;
use App\Services\RegionsInformation\Models\Region;
use App\Services\RegionsInformation\RegionsInformationInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RefreshPolygonsProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private RefreshJob $refreshJob;

    /**
     * Create a new job instance.
     */
    public function __construct(RefreshJob $refreshJob)
    {
        $this->refreshJob = $refreshJob;
    }

    /**
     * Execute the job.
     */
    public function handle(UpdateRegionsInterface $updateRegionsService): void
    {
        $this->refreshJob->setAttribute('status', RefreshJob::STATUS_IN_PROGRESS);
        $this->refreshJob->save();

        $updateQuery = new UpdateQuery($this->refreshJob);

        $updateRegionsService->updateRegions($updateQuery);

        $this->refreshJob->setAttribute('status', RefreshJob::STATUS_FINISHED);
        $this->refreshJob->save();
    }
}
