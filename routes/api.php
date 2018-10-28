<?php

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

Route::group([
    'prefix' => 'auth',
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');

    Route::group([
        'middleware' => 'auth:api',
    ], function () {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});

Route::group([
    'middleware' => 'auth:api',
], function () {
    Route::get('kosts', 'KostController@index');
    Route::post('kost', 'KostController@show');
    Route::post('kosts', 'KostController@store');
    Route::put('kosts', 'KostController@update');
    Route::delete('kosts', 'KostController@destroy');
    // Route::apiResource('rooms', 'RoomController');
});

