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

    public function doesUrlExist($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($code == 200) {
            $status = true;
        } else {
            $status = false;
        }
        curl_close($ch);
        return $status;
    }
}