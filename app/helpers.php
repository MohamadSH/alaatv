<?php

use App\Classes\Nullable;
use App\Classes\Util\Boolean as UtilBoolean;
use Carbon\Carbon;

if (!function_exists('nullable')) {
    function nullable($result, $data = []): Nullable
    {
        return new Nullable($result, $data);
    }
}

if (!function_exists('boolean')) {
    function boolean($result): UtilBoolean
    {
        return new UtilBoolean($result);
    }
}

if (!function_exists('httpResponse')) {
    function httpResponse($api = null, $view = null)
    {
        if (request()->expectsJson()) {
            return $api;
        }
        return $view;
    }
}

if (!function_exists('hasAuthenticatedUserPermission')) {
    function hasAuthenticatedUserPermission(string $permission): bool
    {
        return (Auth::check() && Auth::user()
                ->can($permission));
    }
}
if (!function_exists('clearHtml')) {
    function clearHtml($value): string
    {
        return Purify::clean($value, ['HTML.Allowed' => '']);
    }
}
if (!function_exists('convertTagStringToArray')) {
    function convertTagStringToArray($tagString): array
    {
        $tags = explode(",", $tagString);
        $tags = array_filter($tags);

        return $tags;
    }

}
if (!function_exists('rankInArray')) {
    function rankInArray(array $array , $value): int
    {
        $rank = count($array);
        rsort($array);
        foreach ($array as $key => $item) {
            if($value >= $item )
            {
                $rank = $key;
                break;
            }
        }
        return $rank+1;
    }

}

if (!function_exists('getCurrentWeekDateViaDayName')) {
    function getCurrentWeekDateViaDayName($dayEnglishName): ?string
    {
        $startOfWeekDate = Carbon::now('Asia/Tehran')->startOfWeek(Carbon::SATURDAY);
        if ($dayEnglishName == 'saturday') {
            $date = $startOfWeekDate->toDateString();
        } elseif ($dayEnglishName == 'sunday') {
            $date = $startOfWeekDate->addDay()->toDateString();
        } elseif ($dayEnglishName == 'monday') {
            $date = $startOfWeekDate->addDays(2)->toDateString();
        } elseif ($dayEnglishName == 'tuesday') {
            $date = $startOfWeekDate->addDays(3)->toDateString();
        } elseif ($dayEnglishName == 'wednesday') {
            $date = $startOfWeekDate->addDays(4)->toDateString();
        } elseif ($dayEnglishName == 'thursday') {
            $date = $startOfWeekDate->addDays(5)->toDateString();
        } elseif ($dayEnglishName == 'friday') {
            $date = $startOfWeekDate->addDays(6)->toDateString();
        }
        return (isset($date))?$date:null;
    }

}

if (! function_exists('alaaSetting')) {
    /**
     * Get / set the specified cache value.
     *
     * If an array is passed, we'll assume you want to put to the cache.
     *
     * @param  dynamic  key|key,default|data,expiration|null
     * @return mixed|\Illuminate\Cache\CacheManager
     *
     * @throws \Exception
     */
    function alaaSetting()
    {
        return app('App\Websitesetting');
    }
}
