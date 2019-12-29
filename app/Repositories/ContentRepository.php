<?php


namespace App\Repositories;


use App\Content;
use Illuminate\Database\Query\Builder;

class ContentRepository
{
    /**
     * @param int $userId
     *
     * @return Builder
     */
    public static function getContentsetByUserId(int $userId)
    {
        return Content::select('educationalcontents.contentset_id')
            ->where('author_id', $userId)
            ->where('isFree', 0)
            ->groupby('contentset_id');
    }
}
