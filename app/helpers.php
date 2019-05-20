<?php

use App\Classes\Nullable;
use App\Classes\Util\Boolean as UtilBoolean;

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
