<?php

namespace App\Listeners;

use Cookie;
use App\Events\Authenticated;

class RegisteredListener
{
    public function handle($event)
    {
        setcookie( 'nocache', '1', time() + (86400*30), '/');
    }
}
