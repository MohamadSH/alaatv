<?php

namespace App\Listeners;

use App\Events\MobileVerified;
use Illuminate\Support\Facades\Cache;

class MobileVerifiedListener
{
    /**
     * Handle the event.
     *
     * @param  MobileVerified  $event
     *
     * @return void
     */
    public function handle(MobileVerified $event)
    {
        $event->user->sendMobileVerifiedNotification();
        Cache::tags('User:'.$event->user->id)->flush();
    }
}
