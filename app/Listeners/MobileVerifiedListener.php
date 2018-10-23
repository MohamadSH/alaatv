<?php

namespace App\Listeners;

use App\Events\MobileVerified;

class MobileVerifiedListener
{
    /**
     * Handle the event.
     *
     * @param MobileVerified $event
     * @return void
     */
    public function handle(MobileVerified $event)
    {
        $event->user->sendMobileVerifiedNotification();
    }
}
