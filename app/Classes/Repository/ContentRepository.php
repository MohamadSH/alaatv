<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2019-04-26
 * Time: 04:08
 */

namespace App\Classes\Repository;


use App\Content;
use Illuminate\Support\Facades\Cache;

class ContentRepository implements ContentRepositoryInterface
{
    public function getContentById($contentId): Content
    {
        $key = 'content:' . $contentId;
        return Cache::tags(['content', 'content_' . $contentId])
            ->remember($key, config("constants.CACHE_600"), function () use ($contentId) {
                return Content::find($contentId) ?: new Content();
            });
    }
}
