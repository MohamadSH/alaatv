<?php

namespace App\Events;

use App\Classes\FavorableInterface;
use App\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UnfavoriteEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     *
     * @var User
     */
    public $user;

    /**
     *
     * @var FavorableInterface
     */
    public $favorable;

    /**
     * Create a new event instance.
     *
     * @param User               $user
     * @param FavorableInterface $favorable
     */

    public function __construct(User $user, FavorableInterface $favorable)
    {
        $this->user      = $user;
        $this->favorable = $favorable;
    }
}
