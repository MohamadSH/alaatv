<?php namespace App\Traits;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

trait RequestCommon
{
    /**
     * @param Request $request
     * @param $index
     * @return array|bool|\Illuminate\Http\UploadedFile|mixed|null
     */
    public function requestHasFile(Request $request, $index)
    {
        $hasFile = true;
        if ($request->has($index)) {
            $file = $request->file($index);
            if (!isset($file)) {
                $file = $request->get($index);
                if (!is_file($file)) $hasFile = false;
            }
        } else {
            $hasFile = false;
        }

        if ($hasFile)
            return $file;
        else
            return $hasFile;
    }

    /**
     * @param FormRequest $request
     * @return bool
     */
    public function isRequestFromApp(FormRequest $request): bool
    {
        $isApp = (strlen(strstr($request->header('User-Agent'), "Alaa")) > 0) ? true : false;
        return $isApp;
    }
}