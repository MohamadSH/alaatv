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
