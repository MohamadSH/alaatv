<?php


namespace App\Repositories;


use App\Content;

class ContentRepository
{
    /**
     * @param int $userId
     * @return \Illuminate\Database\Query\Builder
     */
    public static function getContentsetByUserId(int $userId){
        return Content::select('educationalcontents.contentset_id')
                        ->where('author_id', $userId)
                        ->where('isFree', 0)
                        ->groupby('contentset_id');
    }
}
