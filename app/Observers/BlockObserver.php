<?php

namespace App\Observers;

use App\Block;
use Illuminate\Support\Facades\Cache;

class BlockObserver
{
    /**
     * Handle the block "created" event.
     *
     * @param  \App\Block  $block
     * @return void
     */
    public function created(Block $block)
    {
        //
    }

    /**
     * Handle the block "updated" event.
     *
     * @param  \App\Block  $block
     * @return void
     */
    public function updated(Block $block)
    {
        //
    }

    /**
     * Handle the block "deleted" event.
     *
     * @param  \App\Block  $block
     * @return void
     */
    public function deleted(Block $block)
    {
        //
    }

    /**
     * Handle the block "restored" event.
     *
     * @param  \App\Block  $block
     * @return void
     */
    public function restored(Block $block)
    {
        //
    }

    /**
     * Handle the block "force deleted" event.
     *
     * @param  \App\Block  $block
     * @return void
     */
    public function forceDeleted(Block $block)
    {
        //
    }

    public function saved(Block $block)
    {
        $tags = ['block_'.$block->id ];

        if($block->type == 1){
            $tags[]= 'home';
        }
        elseif($block->type == 2){
            $tags[]= 'shop';
        }
        Cache::tags($tags)->flush();
    }
}
