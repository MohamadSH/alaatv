<?php

namespace App\Http;

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\CompleteInfo;
use Laratrust\Middleware\LaratrustRole;
use Illuminate\Auth\Middleware\Authorize;
use App\Http\Middleware\RemoveOrderCoupon;
use Laratrust\Middleware\LaratrustAbility;
use Nckg\Minify\Middleware\MinifyResponse;
use Laratrust\Middleware\LaratrustPermission;
use Illuminate\Http\Middleware\SetCacheHeaders;
use Illuminate\Session\Middleware\StartSession;
use App\Http\Middleware\CheckForMaintenanceMode;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\CanAccessEmployeeTimeSheet;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Routing\Middleware\ValidateSignature;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use App\Http\Middleware\ModifyRequestInputMiddleware;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Laravel\Passport\Http\Middleware\CreateFreshApiToken;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;

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
        CheckForMaintenanceMode::class,
        ValidatePostSize::class,
        Middleware\TrimStrings::class,
        ConvertEmptyStringsToNull::class,
        Middleware\TrustProxies::class,
        MinifyResponse::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            Middleware\EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            AuthenticateSession::class,
            ShareErrorsFromSession::class,
            Middleware\VerifyCsrfToken::class,
            SubstituteBindings::class,
            CreateFreshApiToken::class,
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
        'auth'                                      => Authenticate::class,
        'auth.basic'                                => AuthenticateWithBasicAuth::class,
        'bindings'                                  => SubstituteBindings::class,
        'can'                                       => Authorize::class,
        'guest'                                     => RedirectIfAuthenticated::class,
        'throttle'                                  => ThrottleRequests::class,
        'verified'                                  => EnsureEmailIsVerified::class,
        'cache.headers'                             => SetCacheHeaders::class,
        'completeInfo'                              => CompleteInfo::class,
        'role'                                      => LaratrustRole::class,
        'permission'                                => LaratrustPermission::class,
        'ability'                                   => LaratrustAbility::class,
        'convert'                                   => ModifyRequestInputMiddleware::class,
        'CheckPermissionForSendOrderId'             => Middleware\CheckPermissionForSendOrderId::class,
        'CheckPermissionForSendExtraAttributesCost' => Middleware\CheckPermissionForSendExtraAttributesCost::class,
        'OrderCheckoutReview'                       => Middleware\OrderCheckoutReview::class,
        'OrderCheckoutPayment'                      => Middleware\OrderCheckoutPayment::class,
        'SubmitOrderCoupon'                         => Middleware\SubmitOrderCoupon::class,
        'RemoveOrderCoupon'                         => RemoveOrderCoupon::class,
        'signed'                                    => ValidateSignature::class,
        'CanAccessEmployeeTimeSheet'                => CanAccessEmployeeTimeSheet::class,

    ];
    
    /**
     * The priority-sorted list of middleware.
     *
     * This forces non-global middleware to always be in the given order.
     *
     * @var array
     */
    protected $middlewarePriority = [
        StartSession::class,
        ShareErrorsFromSession::class,
        Authenticate::class,
        AuthenticateSession::class,
        SubstituteBindings::class,
        Authorize::class,
    ];
}
