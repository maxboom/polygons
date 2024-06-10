<?php

namespace App\Providers;

use App\Services\Data\DataService;
use App\Services\Data\PurgeDataInterface;
use App\Services\Data\RefreshDataInterface;
use App\Services\Data\SearchDataInterface;
use App\Services\Data\UpdateRegionsInterface;
use App\Services\GeoInfo\GeoInfo;
use App\Services\GeoInfo\GeoInfoInterface;
use App\Services\RegionsInformation\RegionsInformation;
use App\Services\RegionsInformation\RegionsInformationInterface;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(RegionsInformationInterface::class, RegionsInformation::class);
        $this->app->bind(ClientInterface::class, Client::class);
        $this->app->bind(GeoInfoInterface::class, GeoInfo::class);

        $this->app->bind(SearchDataInterface::class, DataService::class);
        $this->app->bind(RefreshDataInterface::class, DataService::class);
        $this->app->bind(PurgeDataInterface::class, DataService::class);
        $this->app->bind(UpdateRegionsInterface::class, DataService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
