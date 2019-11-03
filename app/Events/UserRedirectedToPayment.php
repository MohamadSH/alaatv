<?php

namespace App\Events;

use App\Order;
use App\Transaction;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class UserRedirectedToPayment
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $order;
    public $transaction;

    /**
     * Create a new event instance.
     *
     * @param User $user
     * @param Order|null $order
     * @param Transaction|null $transaction
     */
    public function __construct(User $user , Order $order = null , Transaction $transaction = null)
    {
        $this->user = $user;
        $this->order = $order;
        $this->transaction = $transaction;
    }
}
