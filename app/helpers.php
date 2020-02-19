<?php

use App\Classes\Nullable;
use App\Classes\Util\Boolean as UtilBoolean;
use Carbon\Carbon;
use Illuminate\Cache\CacheManager;

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
    function rankInArray(array $array, $value): int
    {
        $rank = count($array);
        rsort($array);
        foreach ($array as $key => $item) {
            if ($value >= $item) {
                $rank = $key;
                break;
            }
        }
        return $rank + 1;
    }

}

if (!function_exists('getCurrentWeekDateViaDayName')) {
    function getCurrentWeekDateViaDayName($dayEnglishName): ?string
    {
        $startOfWeekDate = Carbon::now('Asia/Tehran')->startOfWeek(Carbon::SATURDAY);
        if ($dayEnglishName == 'saturday') {
            $date = $startOfWeekDate->toDateString();
        } else if ($dayEnglishName == 'sunday') {
            $date = $startOfWeekDate->addDay()->toDateString();
        } else if ($dayEnglishName == 'monday') {
            $date = $startOfWeekDate->addDays(2)->toDateString();
        } else if ($dayEnglishName == 'tuesday') {
            $date = $startOfWeekDate->addDays(3)->toDateString();
        } else if ($dayEnglishName == 'wednesday') {
            $date = $startOfWeekDate->addDays(4)->toDateString();
        } else if ($dayEnglishName == 'thursday') {
            $date = $startOfWeekDate->addDays(5)->toDateString();
        } else if ($dayEnglishName == 'friday') {
            $date = $startOfWeekDate->addDays(6)->toDateString();
        }
        return (isset($date)) ? $date : null;
    }

}

if (!function_exists('alaaSetting')) {
    /**
     * Get / set the specified cache value.
     *
     * If an array is passed, we'll assume you want to put to the cache.
     *
     * @param dynamic  key|key,default|data,expiration|null
     *
     * @return mixed|CacheManager
     *
     * @throws Exception
     */
    function alaaSetting()
    {
        return app('App\Websitesetting');
    }
}

if (!function_exists('convertRedirectUrlToApiVersion')) {
    function convertRedirectUrlToApiVersion(string $url, string $apiVersion = '1')
    {
        $url = parse_url($url);

        return url('/api/v' . $apiVersion . $url['path']);
    }
}

if (!function_exists('pureHTML')) {
    function pureHTML(string $text)
    {
        return Purify::clean($text, ['HTML.Allowed' => 'div,b,a[href]']);
    }
}
