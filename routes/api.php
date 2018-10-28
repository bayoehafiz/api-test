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
    // Kosts
    Route::get('kosts', 'KostController@index');
    Route::get('kosts/{id}', 'KostController@listByUser');
    Route::post('kost', 'KostController@show');
    Route::post('kosts', 'KostController@store');
    Route::put('kosts', 'KostController@update');
    Route::delete('kosts', 'KostController@destroy');

    // Rooms
    Route::get('rooms', 'RoomController@index');
    Route::get('rooms/{id}', 'RoomController@listByKost');
    Route::post('room', 'RoomController@show');
    Route::post('rooms', 'RoomController@store');
    Route::post('rooms/status', 'RoomController@updateStatus'); // updating room availability status
    Route::put('rooms', 'RoomController@update');
    Route::delete('rooms', 'RoomController@destroy');

    // Credits
    Route::get('credits', 'CreditController@index');
    Route::get('credits/{id}', 'CreditController@listByUser');
    Route::post('credit', 'CreditController@show');
    Route::post('credits', 'CreditController@store');
    Route::post('credits/check', 'CreditController@checkReset'); // check if credit needs to reset its amount
    Route::put('credits', 'CreditController@update');
    Route::delete('credits', 'CreditController@destroy');

    // Credit Usages
    Route::get('usages/{id}', 'CreditUsageController@listByCredit');
    Route::post('usage', 'CreditUsageController@store');
});

