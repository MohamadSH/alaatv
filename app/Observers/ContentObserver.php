<?php

namespace App\Observers;

use App\Classes\Search\TaggingInterface;
use App\Content;
use App\Traits\TaggableTrait;
use Illuminate\Support\Facades\Artisan;

class ContentObserver
{
    private $tagging;
    
    use TaggableTrait;
    
    public function __construct(TaggingInterface $tagging)
    {
        $this->tagging = $tagging;
    }
    
    /**
     * Handle the content "created" event.
     *
     * @param  \App\Content  $content
     *
     * @return void
     */
    public function created(Content $content)
    {
        
    }
    
    /**
     * Handle the content "updated" event.
     *
     * @param  \App\Content  $content
     *
     * @return void
     */
    public function updated(Content $content)
    {
    }
    
    /**
     * Handle the content "deleted" event.
     *
     * @param  \App\Content  $content
     *
     * @return void
     */
    public function deleted(Content $content)
    {
        //
    }
    
    /**
     * Handle the content "restored" event.
     *
     * @param  \App\Content  $content
     *
     * @return void
     */
    public function restored(Content $content)
    {
        //
    }
    
    /**
     * Handle the content "force deleted" event.
     *
     * @param  \App\Content  $content
     *
     * @return void
     */
    public function forceDeleted(Content $content)
    {
        //
    }
    
    /**
     * When issuing a mass update via Eloquent,
     * the saved and updated model events will not be fired for the updated models.
     * This is because the models are never actually retrieved when issuing a mass update.
     *
     * @param  Content  $content
     */
    public function saving(Content $content)
    {
        $content->template_id = $this->findTemplateIdOfaContent($content);
    }
    
    /**
     * @param $content
     *
     * @return int|null
     */
    private function findTemplateIdOfaContent($content)
    {
        return [
                   Content::CONTENT_TYPE_PAMPHLET => Content::CONTENT_TEMPLATE_PAMPHLET,
                   Content::CONTENT_TYPE_EXAM     => Content::CONTENT_TEMPLATE_EXAM,
                   Content::CONTENT_TYPE_VIDEO    => Content::CONTENT_TEMPLATE_VIDEO,
               ][$content->contenttype_id] ?? null;
    }
    
    public function saved(Content $content)
    {
        $this->sendTagsOfTaggableToApi($content, $this->tagging);
        Artisan::call('cache:clear');
    }
}
