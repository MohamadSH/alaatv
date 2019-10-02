<?php

namespace App\Listeners;

use Cookie;
use App\Events\Authenticated;

class AuthenticatedListener
{
    /**
     * Handle the event.
     *
     * @param  Authenticated  $event
     *
     * @return void
     */
    public function handle(Authenticated $event)
    {
        Cookie::queue(cookie()->forever('nocache', '1'));
    }
}
