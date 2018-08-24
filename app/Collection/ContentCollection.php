<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2018-08-21
 * Time: 15:53
 */

namespace App\Collection;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as BaseCollection;


class ContentCollection extends Collection
{
    public function videos()
    {

    }

    public function pamphlets()
    {

    }

    public function articles()
    {

    }

    public function flashcards()
    {

    }

    public function normalMates(): BaseCollection
    {
        $items = $this;
        $result = collect();
        foreach ($items as $content) {
            $myContentType = optional($content->contenttype)->name;
            $result->push([
                "content" => $content,
                "type" => $myContentType,
                "thumbnail" => $content->thumbnail,
                "session" => $content->session
            ]);
        }
        return $result;
    }
}