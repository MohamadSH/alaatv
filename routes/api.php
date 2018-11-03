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

Auth::routes();

Route::post('uploadFile', 'HomeController@uploadFile');

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'rt'], function () {

        Route::get('id/{bucket}/{id}', "API\TagController@get");
        Route::put('id/{bucket}/{id}', "API\TagController@add");
        Route::delete('id/{bucket}/{id}', "API\TagController@remove");
        Route::get('tags/{bucket}', "API\TagController@index");
        Route::get('flush', "API\TagController@flush");

    });
});
