<?php

namespace App\Http;

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\CacheableWithNginx;
use App\Http\Middleware\CanAccessEmployeeTimeSheet;
use App\Http\Middleware\CheckForMaintenanceMode;
use App\Http\Middleware\CompleteInfo;
use App\Http\Middleware\FindCoupon;
use App\Http\Middleware\FindVoucher;
use App\Http\Middleware\MobileVerification;
use App\Http\Middleware\ModifyRequestInputMiddleware;
use App\Http\Middleware\OpenOrder;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\RemoveOrderCoupon;
use App\Http\Middleware\SubmitVoucher;
use App\Http\Middleware\ValidateCoupon;
use App\Http\Middleware\ValidateVoucher;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Illuminate\Http\Middleware\SetCacheHeaders;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Routing\Middleware\ValidateSignature;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Laratrust\Middleware\LaratrustAbility;
use Laratrust\Middleware\LaratrustPermission;
use Laratrust\Middleware\LaratrustRole;
use Laravel\Passport\Http\Middleware\CreateFreshApiToken;
use Nckg\Minify\Middleware\MinifyResponse;

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
            //            Middleware\VerifyCsrfToken::class,
            SubstituteBindings::class,
            CreateFreshApiToken::class,
            CacheableWithNginx::class,
        ],

        'api' => [
            'throttle:120000,1',
            'bindings',
            CacheableWithNginx::class,
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
        'submitOrderCoupon'                         => Middleware\SubmitOrderCoupon::class,
        'removeOrderCoupon'                         => RemoveOrderCoupon::class,
        'signed'                                    => ValidateSignature::class,
        'CanAccessEmployeeTimeSheet'                => CanAccessEmployeeTimeSheet::class,
        'submitVoucher'                             => SubmitVoucher::class,
        'findCoupon'                                => FindCoupon::class,
        'validateCoupon'                            => ValidateCoupon::class,
        'openOrder'                                 => OpenOrder::class,
        'mobileVerification'                        => MobileVerification::class,
        'findVoucher'                               => FindVoucher::class,
        'validateVoucher'                           => ValidateVoucher::class,
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
