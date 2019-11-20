<?php

/*
    These routes are loaded by the RouteServiceProvider within a group which is assigned the "api" middleware group.
*/

use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ContentController;
use App\Http\Controllers\Api\GetPaymentRedirectEncryptedLink;
use App\Http\Controllers\Api\TagController;

Route::group(['middleware' => 'web'], function () {
    Auth::routes(['verify' => true]);
});

Route::post('big' , [HomeController::class, 'bigUpload'] )->name('api.bigUpload');

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'rt'], function () {

        Route::get('id/{bucket}/{id}', [TagController::class, 'get']);
        Route::put('id/{bucket}/{id}', [TagController::class, 'add']);
        Route::delete('id/{bucket}/{id}', [TagController::class, 'remove']);
        Route::get('tags/{bucket}', [TagController::class, 'index']);
        Route::get('flush', [TagController::class, 'flush']);

    });

    Route::get('lastVersion', 'Api\AppVersionController@show');

    Route::get('debug', 'Api\HomeController@debug');
    Route::get('authTest', 'Api\HomeController@authTest');

    Route::get('c/{c}', 'Api\ContentController@show');
    Route::get('product/{product}', 'Api\ProductController@show');
    Route::get('set/{set}', 'Api\SetController@show');
    Route::post('getPrice/{product}', 'Api\ProductController@refreshPrice');
    Route::post('donate', [OrderController::class, 'donateOrder']);
//    Route::any('fetchProducts', [ProductController::class, 'fetchProducts'])
//        ->name('api.fetch.product');
    Route::any('fetchContents', [ContentController::class, 'fetchContents'])
        ->name('api.fetch.content');

    Route::get('satra', [HomeController::class, 'satra']);

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
            Route::get('review', [OrderController::class, 'checkoutReview'])->name('api.checkout.review');
            Route::get('payment', [OrderController::class, 'checkoutPayment'])->name('api.checkout.payment');
        });

        Route::any('getPaymentRedirectEncryptedLink', '\\'.GetPaymentRedirectEncryptedLink::class)
            ->name('api.payment.getEncryptedLink');
    });
});
