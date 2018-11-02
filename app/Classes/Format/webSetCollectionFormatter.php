<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2018-11-02
 * Time: 18:04
 */

namespace App\Classes\Format;


use App\Collection\SetCollection;

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
            $content = $set->getLastContent();
            $lesson = [
                "displayName" => $set->name,
                "author"      => $set->getLastContent()->author,
                "pic"         => $set->photo,
                "content_id"  => !is_null(optional($content)->id) ? optional($content)->id : 0,
            ];
            $lessons->push($lesson);
        }
        return $lessons;
    }
}