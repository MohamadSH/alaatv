<?php

namespace App\Events;

use App\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Authenticated
{
    use Dispatchable, SerializesModels;

    /**
     * The verified user.
     *
     * @var User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param User $user
     *
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
