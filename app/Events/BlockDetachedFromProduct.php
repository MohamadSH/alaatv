<?php

namespace App\Events;

use App\Block;
use App\Product;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class BlockDetachedFromProduct
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $product;
    public $block;

    /**
     * Create a new event instance.
     *
     * @param Product $product
     * @param Block $block
     */
    public function __construct(Product $product , Block $block)
    {
        $this->product = $product;
        $this->block = $block;
    }
}
