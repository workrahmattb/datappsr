<?php

use App\Http\Controllers\Api\PendaftaranController;
use App\Http\Controllers\Api\MtsputriController;
use App\Http\Controllers\Api\MtsputraController;
use App\Http\Controllers\Api\MaputriController;
use App\Http\Controllers\Api\MaputraController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::resource('/pendaftaran', PendaftaranController::class);
Route::resource('/mtsputri', MtsputriController::class);
Route::resource('/mtsputra', MtsputraController::class);
Route::resource('/maputri', MaputriController::class);
Route::resource('/maputra', MaputraController::class);
