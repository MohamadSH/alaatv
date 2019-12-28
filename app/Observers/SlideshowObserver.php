<?php

namespace App\Observers;

use App\Slideshow;
use Illuminate\Support\Facades\Cache;

class SlideshowObserver
{
    /**
     * Handle the slide show "created" event.
     *
     * @param Slideshow $slidshow
     *
     * @return void
     */
    public function created(Slideshow $slidshow)
    {
        //
    }

    /**
     * Handle the slide show "updated" event.
     *
     * @param Slideshow $slidshow
     *
     * @return void
     */
    public function updated(Slideshow $slidshow)
    {
        //
    }

    /**
     * Handle the slide show "deleted" event.
     *
     * @param Slideshow $slidshow
     *
     * @return void
     */
    public function deleted(Slideshow $slidshow)
    {
        //
    }

    /**
     * Handle the slide show "restored" event.
     *
     * @param Slideshow $slidshow
     *
     * @return void
     */
    public function restored(Slideshow $slidshow)
    {
        //
    }

    /**
     * Handle the slide show "force deleted" event.
     *
     * @param Slideshow $slidshow
     *
     * @return void
     */
    public function forceDeleted(Slideshow $slidshow)
    {
        //
    }

    public function saved(Slideshow $slideshow)
    {
        Cache::tags(['slideshow_' . $slideshow->id])->flush();
        if ($slideshow->websitepage_id == 25) {
            Cache::tags(['home'])->flush();
        } else if ($slideshow->websitepage_id == 9387) {
            Cache::tags(['shop'])->flush();
        }
    }
}
