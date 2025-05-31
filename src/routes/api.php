<?php

use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\RepresentativeController;
use Illuminate\Support\Facades\Route;

Route::apiResource('clients', ClientController::class);
Route::apiResource('cities', CityController::class);
Route::apiResource('representatives', RepresentativeController::class);

Route::get('representatives/by-client/{client}', [RepresentativeController::class, 'byClient']);
Route::get('representatives/by-city/{city}', [RepresentativeController::class, 'byCity']);