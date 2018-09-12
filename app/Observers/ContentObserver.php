<?php

namespace App\Observers;

use App\Classes\Search\Tag\ContentTagManagerViaApi;
use App\Content;
use App\Traits\APIRequestCommon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;

class ContentObserver
{
    /**
     * Handle the content "created" event.
     *
     * @param  \App\Content  $content
     * @return void
     */
    public function created(Content $content)
    {

    }

    /**
     * Handle the content "updated" event.
     *
     * @param  \App\Content  $content
     * @return void
     */
    public function updated(Content $content)
    {
    }

    /**
     * Handle the content "deleted" event.
     *
     * @param  \App\Content  $content
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
     * @param Content $content
     */
    public function saving(Content $content){

        $content->template_id = $this->findTemplateIdOfaContent($content);

    }

    public function saved(Content $content){
        $this->sendTagsOfContentToRedis($content);
        Artisan::call('cache:clear');
    }
    /**
     * @param $content
     */
    private function sendTagsOfContentToRedis($content): void
    {
        if ($content->enable &&
            isset($content->tags) &&
            !empty($content->tags->tags)) {

            (new ContentTagManagerViaApi())->setTags($content->id,
                $content->tags->tags,
                optional($content->created_at)->timestamp
            );
        }
    }

    /**
     * @param $content
     * @return int|null
     */
    private function findTemplateIdOfaContent($content)
    {
        switch ($content->contenttype_id) {
            case Content::CONTENT_TYPE_PAMPHLET : // pamphlet
                return Content::CONTENT_TEMPLATE_PAMPHLET;
                break;
            case Content::CONTENT_TYPE_EXAM : // exam
                return Content::CONTENT_TEMPLATE_EXAM;
                break;
            case Content::CONTENT_TYPE_VIDEO : // video
                return Content::CONTENT_TEMPLATE_VIDEO;
                break;
            default:
                return null;
        }
    }
}
