<?php

use Illuminate\Http\Request;

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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth');

Route::resource('station', 'StationController', ['only' => [
    'index', 'show', 'store'
]]);
Route::resource('station/{station_id}/device', 'DeviceController', ['only' => [
    'index', 'show', 'store'
]]);
Route::resource('station/{station_id}/device/{device_id}/data', 'DeviceDataController', ['only' => [
    'index'
]]);
Route::resource('station/{station_id}/device/{device_id}/config', 'DeviceConfigController', ['only' => [
    'index', 'show', 'store'
]]);
