<?php


namespace App\Traits\Content;


use App\Collection\ProductCollection;
use App\Content;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

trait ContentControllerResponseTrait
{
    
    /**
     * @param                                     $message
     * @param  ProductCollection                  $productsThatHaveThisContent
     * @param  int                                $code
     *
     * @param  bool                               $productInResponse
     *
     * @return Response
     */
    protected function userCanNotSeeContentResponse($message, int $code, ProductCollection $productsThatHaveThisContent = null,
        bool $productInResponse = false): Response
    {
        if ($productInResponse) {
            return response()->json([
                'message' => $message,
                'product' => $productsThatHaveThisContent,
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
}