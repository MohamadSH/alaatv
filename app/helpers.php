<?php
if (!function_exists('nullable')) {
    function nullable($result): \App\Classes\Nullable
    {
        return new \App\Classes\Nullable($result);
    }
}

if (!function_exists('boolean')) {
    function boolean($result): \App\Classes\Util\Boolean
    {
        return new \App\Classes\Util\Boolean($result);
    }
}