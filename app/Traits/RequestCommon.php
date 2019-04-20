<?php namespace App\Traits;

trait RequestCommon
{
    /**
     * @param array $data
     * @param         $index
     *
     * @return array|bool|\Illuminate\Http\UploadedFile|mixed|null
     */
    public function getRequestFile(array $data, $index)
    {
        $hasFile = true;
        if (array_key_exists($index, $data)) {
            $file = $data[$index];
            if (! is_file($file)) {
                $hasFile = false;
            }
        } else {
            $hasFile = false;
        }

        if ($hasFile) {
            return $file;
        } else {
            return $hasFile;
        }
    }

    /**
     * @param \Illuminate\Foundation\Http\FormRequest $request
     *
     * @return bool
     */
    public function isRequestFromApp(\Illuminate\Foundation\Http\FormRequest $request): bool
    {
        $isApp = (strlen(strstr($request->header('User-Agent'), "Alaa")) > 0) ? true : false;

        return $isApp;
    }

    /**
     * Copy source request in to the new request
     *
     * @param \Illuminate\Foundation\Http\FormRequest $sourceRequest
     * @param \Illuminate\Foundation\Http\FormRequest $newRequest
     * @return void
     */
    public function copyRequest(\Illuminate\Foundation\Http\FormRequest $sourceRequest, \Illuminate\Foundation\Http\FormRequest &$newRequest): void
    {
        $newRequest->merge($sourceRequest->all());
        $user = $sourceRequest->user();
        if (isset($user)) {
            $newRequest->setUserResolver(function () use ($user) {
                return $user;
            });
        }
    }

    /**
     * Converts a request to an Ajax request
     *
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @return void
     */
    static public function convertRequestToAjax(\Illuminate\Foundation\Http\FormRequest &$request): void
    {
        $request->headers->add(["X-Requested-With" => "XMLHttpRequest"]);
    }
}