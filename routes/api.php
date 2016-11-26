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

Route::group(['prefix' => 'storage'], function () {
    Route::get('info', 'StorageController@info');
    Route::get('delete', 'StorageController@delete');
    Route::get('url', 'StorageController@url');

    Route::post('upload', 'StorageController@upload');
});