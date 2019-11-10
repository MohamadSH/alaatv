<?php

namespace App\Listeners;

use App\Content;
use App\Contentset;
use App\Events\FavoriteEvent;
use App\Product;
use Illuminate\Support\Facades\Cache;

class FavoriteEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  FavoriteEvent  $event
     * @return void
     */
    public function handle(FavoriteEvent $event)
    {
        if($event instanceof Content){
            Cache::tags('user_'.$event->user->id.'_favoriteContents')->flush();
        }elseif($event instanceof Contentset){
            Cache::tags('user_'.$event->user->id.'_favoriteSets')->flush();
        }elseif($event instanceof Product){
            Cache::tags('user_'.$event->user->id.'_favoriteProducts')->flush();
        }else{
            Cache::tags('user_'.$event->user->id.'_favorites')->flush();
        }
        Cache::tags('favorite_'.$event->favorable->id)->flush();
    }
}
