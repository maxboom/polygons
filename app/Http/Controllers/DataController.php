<?php

namespace App\Http\Controllers;

use App\Http\Requests\DataRequest;
use App\Http\Requests\PurgeRequest;
use App\Http\Requests\RefreshJobRequest;
use App\Http\Requests\SearchRequest;
use App\Services\Data\Models\RefreshOptions;
use App\Services\Data\Models\SearchQuery;
use App\Services\Data\PurgeDataInterface;
use App\Services\Data\RefreshDataInterface;
use App\Services\Data\SearchDataInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;

class DataController extends Controller
{
    public function refresh(RefreshJobRequest $request, RefreshDataInterface $refreshDataService): Response
    {
        $delayInSeconds = $request->get('delaySeconds');
        $refreshOptions = new RefreshOptions($delayInSeconds);

        $refreshDataService->refresh($refreshOptions);

        return response([
            'data' => ['success' => true]
        ]);
    }

    public function search(SearchRequest $searchRequest, SearchDataInterface $searchDataService): Response
    {
        $longitude = $searchRequest->get('lon');
        $latitude = $searchRequest->get('lat');
        $searchQuery = new SearchQuery($longitude, $latitude);
        $searchResponse = $searchDataService->search($searchQuery);

        return response([
            'data' => [
                'oblast' => $searchResponse->getRegion()->name ?? null,
                'cache' => $searchResponse->isUsedCache() ? 'true' : 'miss',
            ]
        ]);
    }

    public function purge(PurgeRequest $purgeRequest, PurgeDataInterface $purgeDataService): Response
    {
        $purgeDataService->purge();

        return response([
            'data' => ['status' => 'success']
        ]);
    }
}
