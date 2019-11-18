<?php

namespace App\Listeners;

use App\Events\SendProductIntroducingBlockTags;
use App\Traits\APIRequestCommon;

class SendProductIntroducingBlockTagsListener
{
    use APIRequestCommon;
    /**
     * Handle the event.
     *
     * @param  SendProductIntroducingBlockTags  $event
     * @return void
     */
    public function handle(SendProductIntroducingBlockTags $event)
    {
        $product = $event->product;
        $contentIds = [];

        $blocks = $product->blocks;

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

        if(!empty($itemTagsArray)){
            $params = [
                'tags' => json_encode($itemTagsArray, JSON_UNESCAPED_UNICODE),
            ];

            $response = $this->sendRequest(config('constants.TAG_API_URL').'id/relatedproduct/'.$product->id, 'PUT', $params);
        }
    }
}
