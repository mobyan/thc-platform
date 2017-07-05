<?php

use Illuminate\Http\Request;
use App\User;
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
Route::get('user/my', 'UserController@my');

Route::post('apply/{apply}/pass', 'ApplyController@pass');
Route::post('apply/{apply}/unpass', 'ApplyController@unpass');
Route::resource('apply', 'ApplyController', ['only' => [
    'index', 'show', 'store'
]]);


//user
Route::post('user/detach', 'UserController@detach');

Route::post('user/attach', 'UserController@attach');

Route::resource('user', 'UserController', ['only' => [
    'index', 'show', 'store', 'update', 'destroy'
]]);

Route::resource('user_profile', 'UserProfileController', ['only' => [
    'index', 'update',
]]);

Route::get('invitation/extend/{invitation}', 'InviteController@extend');
Route::resource('invitation','InviteController',['only' => ['index','show','update','store','destroy',
]]);

Route::resource('role', 'RoleController', ['only' => [
    'index', 'show'
]]);

Route::get('app/schema', 'AppController@schema');
Route::resource('app', 'AppController', ['only' => [
    'index', 'show', 'store', 'update', 'destroy',
]]);

//Route::resource('code', 'CodeController',['only' =>[
//  'index','show'
//  ]]);
Route::get('code/search', 'CodeController@search');
Route::get('code/subs', 'CodeController@subs');
Route::resource('code','CodeController',['only'=>['index', 'show']]);



Route::get('station/schema', 'StationController@schema');
Route::resource('station', 'StationController', ['only' => [
    'index', 'show', 'store', 'update', 'destroy'
],
'middleware' => ['permission:manage_station'],
]);
Route::resource('station/{station}/device', 'DeviceController', ['only' => [
    'index', 'show', 'store', 'update', 'destroy'
]]);
Route::resource('station/{station}/device/{device}/data', 'DeviceDataController', ['only' => [
    'index'
]]);
Route::resource('station/{station}/device/{device}/config', 'DeviceConfigController', ['only' => [
    'index', 'show', 'store', 'update'
]]);
Route::resource('station/{station}/alert', 'AlertController', ['only' => [
    'index'
]]);
Route::resource('download', 'DownloadController', ['only' => [
    'index', 'show', 'store', 'update', 'destroy'
]]);
