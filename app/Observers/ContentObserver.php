<?php

namespace App\Observers;

use App\Classes\Search\TaggingInterface;
use App\Content;
use App\Events\ContentRedirected;
use App\Jobs\InsertContentToSatra;
use App\Traits\TaggableTrait;
use Illuminate\Support\Facades\Cache;

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
     * @param Content $content
     *
     * @return void
     */
    public function created(Content $content)
    {
        dispatch(new InsertContentToSatra($content));
    }

    /**
     * Handle the content "updated" event.
     *
     * @param Content $content
     *
     * @return void
     */
    public function updated(Content $content)
    {
//        (new SatraSyncer())->updateContentInfo($content);
    }

    /**
     * Handle the content "deleted" event.
     *
     * @param Content $content
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
     * @param Content $content
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
     * @param Content $content
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
     * @param Content $content
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
                Content::CONTENT_TYPE_ARTICLE  => Content::CONTENT_TEMPLATE_ARTICLE,
            ][$content->contenttype_id] ?? null;
    }

    public function saved(Content $content)
    {
        if (isset($content->redirectUrl)) {
            if ($content->isFree && auth()->check() && auth()->user()->can(config('constants.REMOVE_EDUCATIONAL_CONTENT_FILE_ACCESS'))) {
                event(new ContentRedirected($content));
            }
            $this->removeTagsOfTaggable($content, $this->tagging);
        } else {
            $this->sendTagsOfTaggableToApi($content, $this->tagging);
        }

        Cache::tags([
            'content_' . $content->id,
            'set_' . $content->contentset_id . '_contents',
            'set_' . $content->contentset_id . '_setMates',
            'content_search',
            'set_search',
        ])->flush();
    }
}
