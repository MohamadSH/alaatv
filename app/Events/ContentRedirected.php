<?php

namespace App\Events;

use App\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ContentRedirected
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $content;

    /**
     * Create a new event instance.
     *
     * @param Content $content
     */
    public function __construct(Content $content)
    {
        $this->content = $content;
    }
}
