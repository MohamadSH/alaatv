<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Illuminate\Auth\Events\Registered' => [
            //            SendMobileVerificationNotification::class,
            //            SendEmailVerificationNotification::class,
        ],
        'App\Events\MobileVerified' => [
            'App\Listeners\MobileVerifiedListener',
        ],
        'App\Events\FreeInternetAccept' => [
            'App\Listeners\FreeInternetAcceptListener',
        ],
        'Laravel\Passport\Events\AccessTokenCreated' => [
//            'App\Listeners\RevokeOldTokens',
        ],

        'Laravel\Passport\Events\RefreshTokenCreated' => [
//            'App\Listeners\PruneOldTokens',
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
