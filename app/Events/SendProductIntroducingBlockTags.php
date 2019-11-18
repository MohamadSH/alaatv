<?php

namespace App\Events;

use App\Block;
use App\Product;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class SendProductIntroducingBlockTags
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $product;

    /**
     * Create a new event instance.
     *
     * @param Product $product
     * @param Block $block
     */
    public function __construct(Product $product)
    {
        $this->product = $product ;
    }
}
