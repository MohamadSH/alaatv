<?php

namespace App\Events;

use App\Order;
use Illuminate\Queue\SerializesModels;

class FillTmpShareOfOrder
{
    use SerializesModels;
    
    /**
     * The verified user.
     *
     * @var MustVerifyMobileNumber
     */
    public $order;

    /**
     * Create a new event instance.
     *
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}
