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

# API
Route::group(['as' => 'nAPI::'], function() {
	Route::get('/printer/{id}/{api}', 'APIController@printer')->name('printer');
    Route::get('/file/{name}/{api}', 'APIController@file')->name('file');
	Route::get('/register/{host}/{name}/{api}', 'APIController@register');
});

Route::group(['namespace' => 'Laralum', 'as' => 'API::'], function () {
    Route::get('/{table}/{accessor?}/{data?}', 'APIController@show')->name('show');
});
