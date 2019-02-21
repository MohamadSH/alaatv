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

Auth::routes(['verify' => true]);

Route::post('uploadFile', 'Web\HomeController@uploadFile');

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'rt'], function () {

        Route::get('id/{bucket}/{id}', "Api\TagController@get");
        Route::put('id/{bucket}/{id}', "Api\TagController@add");
        Route::delete('id/{bucket}/{id}', "Api\TagController@remove");
        Route::get('tags/{bucket}', "Api\TagController@index");
        Route::get('flush', "Api\TagController@flush");

    });

    Route::get('debug', 'Api\HomeController@debug');
    Route::get('authTest', 'Api\HomeController@authTest');

    Route::get('c/{c}', 'Api\ContentController@show');
    Route::get('product/{product}', 'Api\ProductController@show');
    Route::get('set/{set}', 'Api\SetController@show');
    Route::post('getPrice/{product}', 'Api\ProductController@refreshPrice');


    Route::group(['middleware' => 'auth:api'], function () {
        Route::group(['prefix' => 'user'], function () {
            Route::get('{user}/orders', 'Api\UserController@userOrders');
            Route::get('{user}/dashboard', 'Api\DashboardPageController')->name('api.user.dashboard');
        });
    });
});
