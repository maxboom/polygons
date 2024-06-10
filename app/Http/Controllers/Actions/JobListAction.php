<?php

namespace App\Http\Controllers\Actions;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobListRequest;
use App\Models\RefreshJob;
use Illuminate\Http\Response;

class JobListAction extends Controller
{
    public function __invoke(JobListRequest $request): Response
    {
        $limit = $request->get('limit');

        return response(['data' => RefreshJob::limit($limit)->get()]);
    }
}
