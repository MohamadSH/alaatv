<?php

namespace App\Listeners;

use App\Events\BlockDetachedFromProduct;
use App\Traits\APIRequestCommon;

class BlockDetachedFromProductListener
{
    use APIRequestCommon;
    /**
     * Handle the event.
     *
     * @param  BlockDetachedFromProduct  $event
     * @return void
     */
    public function handle(BlockDetachedFromProduct $event)
    {
        $product = $event->product;
        $block = $event->block;
        $contentIds = [];

        $blocks = $product->blocks->where('id' , '<>' , $block->id);

        foreach ($blocks as $block){
            $blockContents = optional(optional(optional($block)->contents)->pluck('id'))->toArray();
            if(!is_null($blockContents)){
                $contentIds = array_merge( $contentIds , $blockContents );
            }

            $blockFirstSetContents = optional(optional(optional(optional($block->sets)->first())->contents)->pluck('id'))->toArray();
            if(!is_null($blockFirstSetContents)){
                $contentIds = array_merge( $contentIds , $blockFirstSetContents );
            }
        }

        $itemTagsArray = [];
        foreach ($contentIds as $id) {
            $itemTagsArray[] = 'c-'.$id;
        }

        $params = [
            'tags' => json_encode($itemTagsArray, JSON_UNESCAPED_UNICODE),
        ];

        $response = $this->sendRequest(config('constants.TAG_API_URL').'id/relatedproduct/'.$event->product->id, 'PUT', $params);
    }
}
