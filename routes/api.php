<?php

/*
    These routes are loaded by the RouteServiceProvider within a group which is assigned the "api" middleware group.
*/

use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\GetPaymentRedirectEncryptedLink;
use App\Http\Controllers\Api\ProductController;

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

    Route::get('lastVersion', 'Api\AppVersionController@show');

    Route::get('debug', 'Api\HomeController@debug');
    Route::get('authTest', 'Api\HomeController@authTest');

    Route::get('c/{c}', 'Api\ContentController@show');
    Route::get('product/{product}', 'Api\ProductController@show');
    Route::get('set/{set}', 'Api\SetController@show');
    Route::post('getPrice/{product}', 'Api\ProductController@refreshPrice');
    Route::post('donate', [OrderController::class, 'donateOrder']);
    Route::any('fetchProducts', [ProductController::class, 'fetchProducts'])
        ->name('api.fetch.product');


    Route::group(['middleware' => 'auth:api'], function () {
        Route::any('user/auth2/profile', 'Api\UserController@getAuth2Profile');
        Route::resource('user', 'Api\UserController');
        Route::resource('orderproduct', 'Api\OrderproductController');
        Route::post('transaction', 'Api\ZarinpalTransactionController');
        Route::post('orderCoupon', 'Api\OrderController@submitCoupon');
        Route::delete('orderCoupon', 'Api\OrderController@removeCoupon');
        Route::group(['prefix' => 'user'], function () {
            Route::get('{user}/orders', 'Api\UserController@userOrders')->name('api.user.orders');
            Route::get('{user}/dashboard', 'Api\DashboardPageController')->name('api.user.dashboard');
            Route::post('{user}/firebasetoken', 'Api\FirebasetokenController@store')->name('api.user.firebasetoken');
        });

        Route::group(['prefix' => 'checkout'], function () {
            Route::get('review', 'Api\OrderController@checkoutReview')->name('api.checkout.review');
            Route::get('payment', 'Api\OrderController@checkoutPayment')->name('api.checkout.payment');
        });
    
        Route::any('getPaymentRedirectEncryptedLink', '\\'.GetPaymentRedirectEncryptedLink::class)
            ->name('api.payment.getEncryptedLink');
    });
});
