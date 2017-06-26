<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/




Route::get('/', 'MainController@index');
Route::get('/eason', 'HomeController@index');

Route::group(['prefix'=> 'eason'],function($router)
{
  $router->get('/', 'HomeController@index');
  Auth::routes();
});

// Route::resource('station', 'StationController', ['only' => [
//     'index', 'show', 'store', 'update', 'destroy'
// ]]);

// Route::resource('station/{station}/device', 'DeviceController', ['only' => [
//     'index', 'show', 'store', 'update', 'destroy'
// ]]);

// Route::get('/station/{station}/dashboard', 'StationController@dashboard');
