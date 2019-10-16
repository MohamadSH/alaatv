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
    private function makeThumbnailFile($thumbnailUrl): array
    {
        return [
            "uuid"     => Str::uuid()->toString(),
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
        $baseUrl = config('constants.DOWNLOAD_SERVER_PROTOCOL').config('constants.CDN_SERVER_NAME').config('constants.DOWNLOAD_SERVER_MEDIA_PARTIAL_PATH');
        return $baseUrl."thumbnails/".$contentset_id."/".$fileName;
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
