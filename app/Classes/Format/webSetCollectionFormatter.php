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
use Illuminate\Support\Facades\Cache;

class webSetCollectionFormatter implements SetCollectionFormatter
{
    /**
     * @param  SetCollection  $sets
     *
     * @return \Illuminate\Support\Collection
     */
    public function format(SetCollection $sets)
    {
        $lessons = collect();
        foreach ($sets as $set) {
            /** @var Contentset $set */
            $lessons->push($this->formatSet($set));
        }
        return $lessons;
    }

    /**
     * @param  \App\Contentset  $set
     *
     * @return array
     */
    private function formatSet(Contentset $set): array
    {
        return Cache::tags(['content', 'set'])
            ->remember('format-set:'.$set->id, config('constants.CACHE_60'), function () use ($set) {
                $content = $set->getLastActiveContent();
                $lesson  = [
                    "displayName"   => $set->shortName,
                    "author"        => $content->author,
                    "pic"           => $set->photo,
                    "content_id"    => $content->id,
                    "content_count" => $set->activeContents->count(),
                ];

                return $lesson;
            });

    }
}
