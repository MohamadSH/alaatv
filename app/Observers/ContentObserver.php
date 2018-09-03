<?php

namespace App\Observers;

use App\Content;
use App\Traits\APIRequestCommon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;

class ContentObserver
{
    use APIRequestCommon;
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
        Artisan::call('cache:clear');
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
        $this->sendTagsOfContentToRedis($content);
    }
    /**
     * @param $content
     */
    private function sendTagsOfContentToRedis($content): void
    {
        if ($content->enable &&
            isset($content->tags) &&
            !empty($content->tags->tags)) {
            $itemTagsArray = $content->tags->tags;
            $params = [
                "tags" => json_encode($itemTagsArray, JSON_UNESCAPED_UNICODE),
            ];

            if (isset($content->created_at))
                $params["score"] = $content->created_at->timestamp;

            $response = $this->sendRequest(
                config("constants.TAG_API_URL") . "id/content/" . $content->id,
                "PUT",
                $params
            );

            if ($response["statusCode"] == Response::HTTP_OK) {
                //TODO:// Redis Response
            }
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
