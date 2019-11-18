<?php

namespace App\Listeners;

use App\Events\BlockAttachedToProduct;
use App\Traits\APIRequestCommon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class BlockAttachedToProductListener
{
    use APIRequestCommon;
    /**
     * Handle the event.
     *
     * @param  BlockAttachedToProduct  $event
     * @return void
     */
    public function handle(BlockAttachedToProduct $event)
    {
        $contentIds = [];

        $blockContents = optional(optional(optional($event->block)->contents)->pluck('id'))->toArray();
        if(!is_null($blockContents)){
            $contentIds = array_merge( $contentIds , $blockContents );
        }

        $blockFirstSetContents = optional(optional(optional(optional($event->block->sets)->first())->contents)->pluck('id'))->toArray();
        if(!is_null($blockFirstSetContents)){
            $contentIds = array_merge( $contentIds , $blockFirstSetContents );
        }

        $itemTagsArray = [];
        foreach ($contentIds as $id) {
            $itemTagsArray[] = 'c-'.$id;
        }

        if(!empty($itemTagsArray)){
            $params = [
                'tags' => json_encode($itemTagsArray, JSON_UNESCAPED_UNICODE),
            ];

            $response = $this->sendRequest(config('constants.TAG_API_URL')."id/relatedproduct/".$event->product->id, 'PUT', $params);
        }
    }
}
