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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('user', 'App\Http\Controllers\UserController');

Route::resource('building', 'App\Http\Controllers\BuildingController');

Route::group(['prefix' => 'control'], function () {
    Route::post('in','App\Http\Controllers\ControlController@in');
    Route::post('out', 'App\Http\Controllers\ControlController@out');
    Route::get('controls', 'App\Http\Controllers\ControlController@controls');
});
