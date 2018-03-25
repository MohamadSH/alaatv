<?php namespace App\Traits;

use Illuminate\Http\Request;

trait RequestCommon
{
    public function requestHasFile(Request $request , $index)
    {
        $hasFile = true;
        if($request->has($index))
        {
            $file = $request->file($index) ;
            if(!isset($file))
            {
                $file = $request->get($index);
                if(!is_file($file)) $hasFile = false;
            }
        }else{
            $hasFile = false;
        }
        if($hasFile) return $file;
        else return $hasFile ;
    }
}