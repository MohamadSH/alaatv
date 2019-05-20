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
     * @param  FormRequest  $request
     * @param  Content      $content
     *
     * @return void
     */
    protected function fillContentFromRequest(FormRequest $request, Content $content): void
    {
        $inputData  = $request->all();
        $time       = $request->get("validSinceTime");
        $validSince = $request->get("validSinceDate");
        $enabled    = $request->has("enable");
        $tagString  = $request->get("tags");
        $files      = json_decode($request->get("files"));
        
        $content->fill($inputData);
        $content->validSince = $this->getValidSinceDateTime($time, $validSince);
        $content->enable     = $enabled ? 1 : 0;
        $content->tags       = convertTagStringToArray($tagString);
        
        if (isset($files)) {
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
     * @param $filename
     * @param $res
     *
     * @return stdClass
     */
    private function makeVideoFileStdClass($filename, $res): stdClass
    {
        $file          = new stdClass();
        $file->name    = $filename;
        $file->res     = $res;
        $file->caption = Content::videoFileCaptionTable()[$res];
        $file->type    = "video";
        $file->url     = null;
        $file->size    = null;
        $file->disk    = config('constants.DISK_FREE_CONTENT');


        return $file;
    }

    /**
     * @param $filename
     * @return stdClass
     */
    private function makePamphletFileStdClass($filename): stdClass
    {
        $file          = new stdClass();
        $file->name    = $filename;
        $file->res     = null;
        $file->caption = 'فایل';
        $file->url     = null;
        $file->size    = null;
        $file->type    = "pamphlet";
        $file->disk    = config('constants.DISK19_CLOUD');

        return $file;
    }

    /**
     * @param $fileName
     * @param $contentset_id
     *
     * @return string
     */
    private function makeThumbnailUrlFromFileName($fileName, $contentset_id): string
    {
        $baseUrl = "https://cdn.sanatisharif.ir/media/";
        //thumbnail
        $thumbnailFileName = pathinfo($fileName, PATHINFO_FILENAME).".jpg";
        $thumbnailUrl      = $baseUrl."thumbnails/".$contentset_id."/".$thumbnailFileName;
        
        return $thumbnailUrl;
    }
    
    public function makeVideoFileArray($fileName, $contentset_id): array
    {
        $fileUrl = [
            "720p" => "/media/".$contentset_id."/HD_720p/".$fileName,
            "480p" => "/media/".$contentset_id."/hq/".$fileName,
            "240p" => "/media/".$contentset_id."/240p/".$fileName,
        ];
        $files   = [];
        $files[] = $this->makeVideoFileStdClass($fileUrl["240p"], "240p");
        
        $files[] = $this->makeVideoFileStdClass($fileUrl["480p"], "480p");
        
        $files[] = $this->makeVideoFileStdClass($fileUrl["720p"], "720p");
        
        return $files;
    }

    public function makePamphletFileArray($fileName): array
    {
        $files   = [];
        $files[] = $this->makePamphletFileStdClass($fileName);
        return $files;
    }

    
}
