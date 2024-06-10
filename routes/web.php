<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/jobs', \App\Http\Controllers\Actions\JobListAction::class);

Route::get('/data', \App\Http\Controllers\DataController::class . '@search');
Route::put('/data', \App\Http\Controllers\DataController::class . '@refresh')
    ->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);
Route::delete('/data', \App\Http\Controllers\DataController::class . '@purge')
    ->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);
