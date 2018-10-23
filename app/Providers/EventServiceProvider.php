<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use App\Listeners\MobileVerifiedListener;
use App\Listeners\FreeInternetAcceptListener;

use Illuminate\Auth\Events\Registered;
use App\Events\FreeInternetAccept;
use App\Events\MobileVerified;


class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
//            SendMobileVerificationNotification::class,
        ],
        MobileVerified::class => [
            MobileVerifiedListener::class
        ],
        FreeInternetAccept::class => [
            FreeInternetAcceptListener::class
        ]
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
