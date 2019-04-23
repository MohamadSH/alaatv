<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2018-11-02
 * Time: 18:04
 */

namespace App\Classes\Format;

use App\Collection\SetCollection;
use App\Contentset;

class webSetCollectionFormatter implements SetCollectionFormatter
{
    /**
     * @param SetCollection $sets
     *
     * @return \Illuminate\Support\Collection
     */
    public function format(SetCollection $sets)
    {
        $lessons = collect();
        foreach ($sets as $set) {
            /** @var Contentset $set */
            $content = $set->getLastContent();
            $lesson = [
                "displayName" => $set->shortName,
                "author" => $set->author,
                "pic" => $set->photo,
                "content_id" => !is_null($content) ? $content->id : 0,
                "content_count" => $set->contents_count,
            ];
            $lessons->push($lesson);
        }
        return $lessons;
    }
}