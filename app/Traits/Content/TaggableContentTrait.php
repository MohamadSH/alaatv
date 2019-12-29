<?php


namespace App\Traits\Content;


use App\Classes\Search\Tag\ContentTagManagerViaApi;

trait TaggableContentTrait
{
    /**
     * Retrieves content's tags
     *
     * @return array
     */
    public function retrievingTags(): array
    {
        return (new ContentTagManagerViaApi())->getTags($this->id);
    }

    public function getTaggableTags()
    {
        return optional($this->tags)->tags;
    }


    public function getTaggableId(): int
    {
        return $this->id;
    }

    public function getTaggableScore()
    {
        return isset($this->created_at) ? $this->created_at->timestamp : null;
    }

    public function isTaggableActive(): bool
    {
        if ($this->isActive() && isset($this->tags) && !empty($this->tags->tags)) {
            return true;
        }

        return false;
    }
}
