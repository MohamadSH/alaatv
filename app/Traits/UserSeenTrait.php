<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2018-08-27
 * Time: 11:42
 */

namespace App\Traits;


use Illuminate\Http\Request;

trait UserSeenTrait
{
    /**
     * @param $request
     * @param $seenCount
     */
    protected function setSeenCountInRequestBody($request, $seenCount): void
    {
        $request->offsetUnset("seenCount");
        if (isset($seenCount))
            $request->offsetSet("seenCount", $seenCount);
    }


    protected function getSeenCountFromRequest(Request $request)
    {
        $seenCount = $request->seenCount;
        $request->offsetUnset("seenCount");
        return $seenCount;
    }

}