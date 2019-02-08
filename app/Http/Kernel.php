<?php

namespace App\Http;

use App\Http\Middleware\ModifyRequestInputMiddleware;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        //        \App\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Http\Middleware\TrustProxies::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            //             \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            //// Other middleware...
            /// You should ensure that the EncryptCookies middleware is listed prior to the  CreateFreshApiToken middleware in your middleware stack
            \Laravel\Passport\Http\Middleware\CreateFreshApiToken::class,
        ],

        'api' => [
            'throttle:120000,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth'          => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic'    => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings'      => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can'           => \Illuminate\Auth\Middleware\Authorize::class,
        'guest'         => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle'      => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'completeInfo'  => \App\Http\Middleware\CompleteInfo::class,
        'role'          => \Laratrust\Middleware\LaratrustRole::class,
        'permission'    => \Laratrust\Middleware\LaratrustPermission::class,
        'ability'       => \Laratrust\Middleware\LaratrustAbility::class,
        'convert'       => ModifyRequestInputMiddleware::class,
        'trimUserUpdateRequest' => \App\Http\Middleware\TrimUserUpdateRequest::class,
        'CheckPermissionForSendOrderId' => \App\Http\Middleware\CheckPermissionForSendOrderId::class,
        'CheckHasOpenOrder' => \App\Http\Middleware\CheckHasOpenOrder::class,
        'AddCookieToCart' => \App\Http\Middleware\AddCookieToCart::class,
        'CheckPermissionForSendExtraAttributesCost' => \App\Http\Middleware\CheckPermissionForSendExtraAttributesCost::class,
        'StoreOrderproductCookieInOpenOrder'    => \App\Http\Middleware\StoreOrderproductCookieInOpenOrder::class,
        'OrderCheckoutReview'    => \App\Http\Middleware\OrderCheckoutReview::class,
        'OrderCheckoutPayment'    => \App\Http\Middleware\OrderCheckoutPayment::class,
        'SubmitOrderCoupon'    => \App\Http\Middleware\SubmitOrderCoupon::class,
        'OfflineVerifyPayment'    => \App\Http\Middleware\OfflineVerifyPayment::class,
    ];
}
