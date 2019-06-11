<?php


namespace App\Traits\Content;


use stdClass;
use App\Content;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Collection\ProductCollection;
use Illuminate\Foundation\Http\FormRequest;

trait ContentControllerResponseTrait
{
    
    /**
     * @param                                     $message
     * @param  int                                $code
     *
     * @param  Content                            $content
     * @param  ProductCollection                  $productsThatHaveThisContent
     * @param  bool                               $productInResponse
     *
     * @return JsonResponse
     */
    protected function userCanNotSeeContentResponse(string $message, int $code, Content $content, ProductCollection $productsThatHaveThisContent = null,
        bool $productInResponse = false): JsonResponse
    {
        if ($productInResponse) {
            return response()->json([
                'message' => $message,
                'content' => $content->makeHidden('file'),
                'product' => isset($productsThatHaveThisContent) && $productsThatHaveThisContent->isEmpty() ? null :
                    $productsThatHaveThisContent,
            ], $code);
            
        }
        return response()->json([
            'message' => $message,
        ], $code);
    }
    
    /**
     * @param  Request  $request
     * @param  Content  $content
     *
     * @param  string   $gard
     *
     * @return bool
     */
    protected function userCanSeeContent(Request $request, Content $content, string $gard): bool
    {
        return $content->isFree || optional($request->user($gard))->hasContent($content);
    }

    /**
     * @param array $inputData
     * @param Content $content
     *
     * @return void
     */
    protected function fillContentFromRequest(array $inputData, Content $content): void
    {
        $validSinceDateTime = array_get($inputData , 'validSinceDate');
        $enabled    = Arr::has($inputData , 'enable');
        $isFree    = Arr::has($inputData , 'isFree');
        $tagString  = array_get($inputData , 'tags');
        $files      = array_get($inputData , 'files' , []);
        
        $content->fill($inputData);
        //ToDo : keep time in $validSinceDateTime
//        $content->validSince = $validSinceDateTime;
        $content->validSince = explode(' ', $validSinceDateTime)[0];
        $content->enable     = $enabled ? 1 : 0;
        $content->isFree     = $isFree ? 1 : 0;
        $content->tags       = convertTagStringToArray($tagString);
        if(!empty($files))
        {
            $this->storeFilesOfContent($content, $files);
        }
    }
    
    /**
     * @param $time
     * @param $validSince
     *
     * @return null|string
     */
    protected function getValidSinceDateTime($time, $validSince): string
    {
        if (isset($time)) {
            if (strlen($time) > 0) {
                $time = Carbon::parse($time)
                    ->format('H:i:s');
            } else {
                $time = "00:00:00";
            }
        }
        if (isset($validSince)) {
            $validSince = Carbon::parse($validSince)
                ->format('Y-m-d'); //Muhammad : added a day because it returns one day behind and IDK why!!
            if (isset($time)) {
                $validSince = $validSince." ".$time;
            }
            
            return $validSince;
        }
        
        return null;
    }
    
    protected function getUserCanNotSeeContentJsonResponse(Content $content, ProductCollection $productsThatHaveThisContent, callable $callback): JsonResponse
    {
        $product_that_have_this_content_is_empty = $productsThatHaveThisContent->isEmpty();
        
        $messageLookupTable = [
            '0' => trans('content.Not Free'),
            '1' => trans('content.Not Free And you can\'t buy it'),
        ];
        $message            = Arr::get($messageLookupTable, (int) $product_that_have_this_content_is_empty);
        
        $callback($message);
        return $this->userCanNotSeeContentResponse($message,
            Response::HTTP_FORBIDDEN, $content, $productsThatHaveThisContent, true);
    }
    
    /**
     * @param $thumbnailUrl
     *
     * @return array
     */
    private function makeThumbanilFile($thumbnailUrl): array
    {
        return [
            "uuid"     => Str::uuid()
                ->toString(),
            "disk"     => config('constants.DISK_FREE_CONTENT'),
            "url"      => $thumbnailUrl,
            "fileName" => parse_url($thumbnailUrl)['path'],
            "size"     => null,
            "caption"  => null,
            "res"      => null,
            "type"     => "thumbnail",
            "ext"      => pathinfo(parse_url($thumbnailUrl)['path'], PATHINFO_EXTENSION),
        ];
    }

    /**
     * @param string $filename
     * @param string $disk
     * @param string $res
     *
     * @param null $url
     * @return stdClass
     */
    private function makeVideoFileStdClass(string $filename,string $disk, string $res , $url=null): stdClass
    {
        $file          = new stdClass();
        $file->name    = $filename;
        $file->res     = $res;
        $file->caption = Content::videoFileCaptionTable()[$res];
        $file->type    = "video";
        $file->url     = $url;
        $file->size    = null;
        $file->disk    = $disk;


        return $file;
    }

    /**
     * @param string $filename
     * @param string $disk
     * @return stdClass
     */
    private function makePamphletFileStdClass(string $filename , string $disk): stdClass
    {
        $file          = new stdClass();
        $file->name    = $filename;
        $file->res     = null;
        $file->caption = Content::pamphletFileCaption();
        $file->url     = null;
        $file->size    = null;
        $file->type    = "pamphlet";
        $file->disk    = $disk;

        return $file;
    }

    /**
     * @param string $fileName
     * @param int $contentset_id
     *
     * @return string
     */
    private function makeThumbnailUrlFromFileName(string $fileName, int $contentset_id): string
    {
        //ToDo : Hard code
        $baseUrl = "https://cdn.sanatisharif.ir/media/";
        //thumbnail
        $thumbnailFileName = pathinfo($fileName, PATHINFO_FILENAME).".jpg";
        $thumbnailUrl      = $baseUrl."thumbnails/".$contentset_id."/".$thumbnailFileName;
        
        return $thumbnailUrl;
    }

    /**
     * @param string $fileName
     * @param string $disk
     * @param int $contentsetId
     * @return array
     */
    public function makeFreeVideoFileArray(string $fileName , string $disk, int $contentsetId): array
    {
        $serverUrl = config('constants.DOWNLOAD_SERVER_PROTOCOL').'cdn.sanatisharif.ir';
        $fileUrl = [
            '720p' => [
                //ToDo : Hard Code!
                'url' => $serverUrl.'/media/'.$contentsetId.'/HD_720p/'.$fileName,
                'partialPath'=> '/media/'.$contentsetId.'/HD_720p/'.$fileName,
            ],
            '480p' => [
                'url' => $serverUrl.'/media/'.$contentsetId.'/hq/'.$fileName,
                'partialPath'=> '/media/'.$contentsetId.'/hq/'.$fileName,
            ],
            '240p' => [
                'url' => $serverUrl.'/media/'.$contentsetId.'/240p/'.$fileName,
                'partialPath'=> '/media/'.$contentsetId.'/240p/'.$fileName,
            ]
        ];

        $files = $this->makeFilesArray($fileUrl , $disk);

        return $files;
    }

    /**
     * @param string $fileName
     * @param string $disk
     * @param int $productId
     * @return array
     */
    public function makePaidVideoFileArray(string $fileName , string $disk , int $productId): array
    {
        $fileUrl = [
            '720p' => [
                'partialPath' =>'/paid/'.$productId.'/video/HD_720p/'.$fileName,
                'url'   => null,
                ],
            '480p' => [
                'partialPath' =>'/paid/'.$productId.'/video/hq/'.$fileName,
                'url'   => null,
                ],
            '240p' => [
                'partialPath' =>'/paid/'.$productId.'/video/240p/'.$fileName,
                'url'   => null,
                ]
        ];

        $files = $this->makeFilesArray($fileUrl , $disk);

        return $files;
    }

    /**
     * @param string $fileName
     * @param string $disk
     * @return array
     */
    public function makeFreePamphletFileArray(string $fileName , string $disk): array
    {
        $files[] = $this->makePamphletFileStdClass($fileName , $disk);
        return $files;
    }

    /**
     * @param string $fileName
     * @param string $disk
     * @param int $productId
     * @return array
     */
    public function makePaidPamphletFileArray(string $fileName , string $disk, int $productId): array
    {
        $files[] = $this->makePamphletFileStdClass("/paid/".$productId."/".$fileName , $disk);
        return $files;
    }

    /**
     * @param array $fileUrl
     * @param string $disk
     * @return array
     */
    private function makeFilesArray(array $fileUrl , string $disk): array
    {
        $files = [];
        foreach ($fileUrl as $key => $url) {
            $files[] = $this->makeVideoFileStdClass($url['partialPath'], $disk, $key , $url['url']);
        }
        return $files;
    }


}
