<?php

namespace App\Observers;

use App\Classes\Search\TaggingInterface;
use App\Content;
use App\Traits\TaggableTrait;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

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
        if(isset($content->redirectUrl)){
            if($content->isFree && auth()->check() && auth()->user()->can(config('constants.REMOVE_EDUCATIONAL_CONTENT_FILE_ACCESS'))){
                if($content->contenttype_id == config('constants.CONTENT_TYPE_VIDEO')){
                    $CDNDisk = config('constants.DISK_FREE_CONTENT');
                    foreach ($content->getVideos() as $video){
                        $path = explode('cdn.alaatv.com', $video->link)[1];
                        if(Storage::disk($CDNDisk)->exists($path)) {
                             Storage::disk($CDNDisk)->delete($path);
                        }
                    }
                }elseif($content->contenttype_id == config('constants.CONTENT_TYPE_PAMPHLET')){
                    $CDNDisk = config('constants.DISK19_CLOUD');
                    foreach ($content->getPamphlets() as $pamphlet){
                        $path = basename($pamphlet->link);
                        if(Storage::disk($CDNDisk)->exists($path)) {
                             Storage::disk($CDNDisk)->delete($path);
                        }
                    }
                }
            }
            $this->removeTagsOfTaggable($content, $this->tagging);
        }else{
            $this->sendTagsOfTaggableToApi($content, $this->tagging);
        }
        Artisan::call('cache:clear');
    }
}
