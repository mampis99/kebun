<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('sensor')->group(function () {
    Route::post('log', 'SensorController@log')->name('sensor-log');
});

Route::post('kebun', 'DashboardController@apiKebun')->name('api-kebun');
Route::post('node', 'KebunController@listNode')->name('api-node');
Route::post('chip', 'KebunController@listChip')->name('api-chip');