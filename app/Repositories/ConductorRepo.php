<?php


namespace App\Repositories;


use App\Conductor;
use Illuminate\Database\Eloquent\Builder;

class ConductorRepo
{
    /**
     * @param string $todayStringDate
     * @return Builder
     */
    public static function isThereLiveStream(string $todayStringDate):Builder
    {
        return Conductor::where('date', $todayStringDate)
            ->whereNull('finish_time');
    }

    /**
     * @param string $todayStringDate
     * @param string $now
     * @return Builder
     */
    public static function getFinishedPrograms(string $todayStringDate , string $now):Builder
    {
        return Conductor::where('date', $todayStringDate)
            ->whereNull('finish_time')
            ->where('scheduled_finish_time' , '<' , $now);
    }

}
