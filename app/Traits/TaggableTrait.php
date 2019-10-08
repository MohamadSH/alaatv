<?php

namespace App\Traits;

use App\Classes\Search\TaggingInterface;
use App\Classes\Taggable;

trait TaggableTrait
{
    /**
     * @param  Taggable          $taggable
     * @param  TaggingInterface  $tagging
     */
    public function sendTagsOfTaggableToApi(Taggable $taggable, TaggingInterface $tagging): void
    {
        if ($taggable->isTaggableActive()) {
            $tagging->setTags($taggable->getTaggableId(), $taggable->getTaggableTags(), $taggable->getTaggableScore());
        }
    }

    /**
     * @param  Taggable          $taggable
     * @param  TaggingInterface  $tagging
     */
    public function removeTagsOfTaggable(Taggable $taggable, TaggingInterface $tagging): void
    {
        $tagging->removeTags($taggable->getTaggableId());
    }
}
