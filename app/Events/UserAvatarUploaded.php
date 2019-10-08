<?php

namespace App\Events;

use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;


class UserAvatarUploaded
{

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $path;
    public $user;

    /**
     * Create a new event instance.
     *
     * @param User $user
     * @param string $path
     */
    public function __construct(User $user , string $path)
    {
        $this->user = $user;
        $this->path = $path;
    }
}
