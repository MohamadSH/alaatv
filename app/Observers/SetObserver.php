<?php

namespace App\Observers;

use App\Classes\Search\TaggingInterface;
use App\Contentset;
use App\Traits\TaggableTrait;
use Illuminate\Support\Facades\Cache;

class SetObserver
{
    private $tagging;

    use TaggableTrait;

    public function __construct(TaggingInterface $tagging)
    {
        $this->tagging = $tagging;
    }

    /**
     * Handle the product "created" event.
     *
     * @param Contentset $set
     *
     * @return void
     */
    public function created(Contentset $set)
    {

    }

    /**
     * Handle the product "updated" event.
     *
     * @param Contentset $set
     *
     * @return void
     */
    public function updated(Contentset $set)
    {
    }

    /**
     * Handle the product "deleted" event.
     *
     * @param Contentset $set
     *
     * @return void
     */
    public function deleted(Contentset $set)
    {
        //
    }

    /**
     * Handle the product "restored" event.
     *
     * @param Contentset $set
     *
     * @return void
     */
    public function restored(Contentset $set)
    {
        //
    }

    /**
     * Handle the product "force deleted" event.
     *
     * @param Contentset $set
     *
     * @return void
     */
    public function forceDeleted(Contentset $set)
    {
        //
    }

    /**
     * When issuing a mass update via Eloquent,
     * the saved and updated model events will not be fired for the updated models.
     * This is because the models are never actually retrieved when issuing a mass update.
     *
     * @param Contentset $set
     */
    public function saving(Contentset $set)
    {


    }

    public function saved(Contentset $set)
    {
        $this->sendTagsOfTaggableToApi($set, $this->tagging);
        Cache::tags(['set_' . $set->id, 'set_search'])->flush();
    }
}
