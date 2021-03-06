<?php


namespace App\Repositories;


use App\Dayofweek;
use Illuminate\Database\Eloquent\Builder;

class WeekRepo
{
    /**
     * @param string $today
     *
     * @return mixed
     */
    public static function getDayOfWeek(string $today): Builder
    {
        return Dayofweek::where('display_name', $today);
    }
}
