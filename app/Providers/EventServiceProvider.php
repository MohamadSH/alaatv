<?php

namespace App\Providers;

use App\Events\Authenticated;
use App\Events\ContentRedirected;
use App\Events\MobileVerified;
use App\Events\FreeInternetAccept;
use App\Events\FillTmpShareOfOrder;
use App\Events\UserAvatarUploaded;
use App\Events\UserRedirectedToPayment;
use App\Listeners\RedirectContentListener;
use App\Listeners\RemoveOldUserAvatarListener;
use App\Listeners\UserRedirectedToPaymentListener;
use Illuminate\Auth\Events\Registered;
use App\Listeners\AuthenticatedListener;
use App\Listeners\MobileVerifiedListener;
use App\Listeners\FreeInternetAcceptListener;
use App\Listeners\FillTmpShareOfOrderListener;
use Laravel\Passport\Events\AccessTokenCreated;
use Laravel\Passport\Events\RefreshTokenCreated;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Authenticated::class       => [
            AuthenticatedListener::class,
        ],
        Registered::class          => [
            //            SendMobileVerificationNotification::class,
            //            SendEmailVerificationNotification::class,
        ],
        MobileVerified::class      => [
            MobileVerifiedListener::class,
        ],
        FillTmpShareOfOrder::class => [
            FillTmpShareOfOrderListener::class,
        ],
        FreeInternetAccept::class  => [
            FreeInternetAcceptListener::class,
        ],
        AccessTokenCreated::class  => [
//            'App\Listeners\RevokeOldTokens',
        ],

        RefreshTokenCreated::class => [
//            'App\Listeners\PruneOldTokens',
        ],
        UserAvatarUploaded::class      => [
            RemoveOldUserAvatarListener::class,
        ],
        ContentRedirected::class      => [
            RedirectContentListener::class,
        ],
        UserRedirectedToPayment::class      => [
            UserRedirectedToPaymentListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        //
    }
}
