<?php namespace App\Traits;

trait FileCommon
{
    /** Obtains file size based on it's url
     *
     * @param string $url
     *
     * @return string
     */
    public function curlGetFileSize($url): string
    {
        $curl = curl_init($url);

        // Issue a HEAD request and follow any redirects.
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        if (isset($_SERVER["HTTP_USER_AGENT"])) {
            curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
        }
        curl_setopt($curl, CURLOPT_MAXREDIRS, 3);

        curl_exec($curl);
        $fileSizeString = "";
        if (! curl_errno($curl)) {
            switch ($http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE)) {
                case 200:
                    $fileSize = curl_getinfo($curl, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
                    $fileSizeString = $this->FileSizeConvert($fileSize);
                    break;
                default:
                    $fileSizeString = "";
            }
        }
        curl_close($curl);

        return $fileSizeString;
    }

    /** Converts file size to Persian string
     *
     * @param $bytes
     *
     * @return string
     */
    function FileSizeConvert($bytes): string
    {
        $result = "";
        $bytes = floatval($bytes);
        $arBytes = [
            0 => [
                "UNIT" => "ترابایت",
                "VALUE" => pow(1024, 4),
            ],
            1 => [
                "UNIT" => "گیگابایت",
                "VALUE" => pow(1024, 3),
            ],
            2 => [
                "UNIT" => "مگابایت",
                "VALUE" => pow(1024, 2),
            ],
            3 => [
                "UNIT" => "کیلوبایت",
                "VALUE" => 1024,
            ],
            4 => [
                "UNIT" => "بایت",
                "VALUE" => 1,
            ],
        ];

        foreach ($arBytes as $arItem) {
            if ($bytes >= $arItem["VALUE"]) {
                $result = $bytes / $arItem["VALUE"];
                $result = str_replace(".", ".", strval(round($result, 2)))." ".$arItem["UNIT"];
                break;
            }
        }

        return $result;
    }
}