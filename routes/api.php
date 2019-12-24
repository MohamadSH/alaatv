<?php

/*
    These routes are loaded by the RouteServiceProvider within a group which is assigned the "api" middleware group.
*/

use App\Http\Controllers\Api\AppVersionController;
use App\Http\Controllers\Api\ContentController;
use App\Http\Controllers\Api\DashboardPageController;
use App\Http\Controllers\Api\FirebasetokenController;
use App\Http\Controllers\Api\GetPaymentRedirectEncryptedLink;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\IndexPageController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OrderproductController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SetController;
use App\Http\Controllers\Api\ShopPageController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ZarinpalTransactionController;
use App\Http\Controllers\Auth\LoginController;

Auth::routes(['verify' => true]);
/*
|--------------------------------------------------------------------------
| V1
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'rt'], function () {

        Route::get('id/{bucket}/{id}', [TagController::class, 'get']);
        Route::put('id/{bucket}/{id}', [TagController::class, 'add']);
        Route::delete('id/{bucket}/{id}', [TagController::class, 'remove']);
        Route::get('tags/{bucket}', [TagController::class, 'index']);
        Route::get('flush', [TagController::class, 'flush']);

    });

    Route::get('lastVersion', [AppVersionController::class, 'show'])->name('api.v1.lastVersion');

    Route::get('debug', [HomeController::class, 'debug'])->name('api.v1.debug');
    Route::get('authTest', [HomeController::class, 'authTest'])->name('api.v1.authTest');

    Route::get('c/{c}', [ContentController::class, 'show'])->name('api.v1.content.show');
    Route::get('product/{product}', [ProductController::class, 'show'])->name('api.v1.product.show');
    Route::get('set/{set}', [SetController::class, 'show'])->name('api.v1.set.show');
    Route::post('getPrice/{product}', [ProductController::class, 'refreshPrice'])->name('api.v1.refreshPrice');
    Route::post('donate', [OrderController::class, 'donateOrder'])->name('api.v1.donate');
    Route::any('fetchContents', [ContentController::class, 'fetchContents'])->name('api.v1.fetch.content');
    Route::get('shop', '\\'. ShopPageController::class)->name('api.v1.shop');
    Route::get('/home', '\\'. IndexPageController::class)->name('api.v1.home');


    Route::get('satra', [HomeController::class, 'satra']);

    Route::group(['middleware' => 'auth:api'], function () {
        Route::any('user/auth2/profile', [UserController::class, 'getAuth2Profile']);
        Route::resource('user', '\\'. UserController::class);
        Route::resource('orderproduct', '\\'. OrderproductController::class);
        Route::post('transaction', '\\'.ZarinpalTransactionController::class)->name('api.v1.zarinpal.transaction.store');
        Route::post('orderCoupon', [OrderController::class, 'submitCoupon'])->name('api.v1.coupon.submit');
        Route::delete('orderCoupon', [OrderController::class, 'removeCoupon'])->name('api.v1.coupon.remove');

        Route::group(['prefix' => 'user'], function () {
            Route::get('{user}/orders', [UserController::class, 'userOrders'])->name('api.v1.user.orders');
            Route::get('{user}/dashboard', '\\'.DashboardPageController::class)->name('api.v1.user.dashboard');
            Route::post('{user}/firebasetoken', [FirebasetokenController::class, 'store'])->name('api.v1.firebasetoken.store');
        });

        Route::group(['prefix' => 'checkout'], function () {
            Route::get('review', [OrderController::class, 'checkoutReview'])->name('api.v1.checkout.review');
            Route::get('payment', [OrderController::class, 'checkoutPayment'])->name('api.v1.checkout.payment');
        });

        Route::any('getPaymentRedirectEncryptedLink', '\\'.GetPaymentRedirectEncryptedLink::class)->name('api.v1.payment.getEncryptedLink');
    });
});

/*
|--------------------------------------------------------------------------
| V2
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'v2'], function () {
    Route::get('lastVersion', [AppVersionController::class, 'show']);
    Route::post('login', [LoginController::class, 'login']);
    Route::get('authTest', [HomeController::class, 'authTest'])->name('api.v2.authTest');

    Route::get('c/{c}', [ContentController::class, 'showV2'])->name('api.v2.content.show');
    Route::get('c', [ContentController::class, 'indexV2'])->name('api.v2.content.index');
    Route::get('product/{product}', [ProductController::class, 'showV2'])->name('api.v2.product.show');
    Route::get('product', [ProductController::class, 'indexV2'])->name('api.v2.product.index');
    Route::get('set/{set}', [SetController::class, 'showV2'])->name('api.v2.set.show');
    Route::post('getPrice/{product}', [ProductController::class, 'refreshPrice'])->name('api.v2.refreshPrice');
    Route::post('donate', [OrderController::class, 'donateOrder'])->name('api.v2.make.donate');
    Route::any('fetchContents', [ContentController::class, 'fetchContents'])->name('api.v2.fetch.content');
    Route::get('shop', '\\'. ShopPageController::class)->name('api.v2.shop');
    Route::get('/home', '\\'. IndexPageController::class)->name('api.v2.home');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::any('user/auth2/profile', [UserController::class, 'getAuth2Profile']);
        Route::get('user/{user}', [UserController::class, 'showV2'])->name('api.v2.user.show');
        Route::put('user/{user}', [UserController::class, 'updateV2'])->name('api.v2.user.update');
        Route::post('orderproduct', [OrderproductController::class, 'storeV2'])->name('api.v2.orderproduct.store')->middleware('CheckPermissionForSendOrderId');
        Route::delete('orderproduct/{orderproduct}', [OrderproductController::class, 'destroy'])->name('api.v2.orderproduct.destroy');
        Route::post('transaction', '\\'.ZarinpalTransactionController::class)->name('api.v2.zarinpal.transaction.store');
        Route::post('orderCoupon', [OrderController::class, 'submitCouponV2'])->name('api.v2.coupon.submit');
        Route::delete('orderCoupon', [OrderController::class, 'removeCoupon'])->name('api.v2.coupon.remove');


        Route::group(['prefix' => 'user'], function () {
            Route::get('{user}/orders', [UserController::class, 'userOrdersV2'])->name('api.v2.user.orders');
            Route::get('{user}/dashboard', '\\'.DashboardPageController::class)->name('api.v2.user.dashboard');
            Route::post('{user}/firebasetoken', [FirebasetokenController::class, 'store'])->name('api.v2.firebasetoken.store');
        });

        Route::group(['prefix' => 'checkout'], function () {
            Route::get('review', [OrderController::class, 'checkoutReviewV2'])->name('api.v2.checkout.review');
            Route::get('payment', [OrderController::class, 'checkoutPaymentV2'])->name('api.v2.checkout.payment');
        });

        Route::any('getPaymentRedirectEncryptedLink', '\\'.GetPaymentRedirectEncryptedLink::class)->name('api.v2.payment.getEncryptedLink');
    });
});
