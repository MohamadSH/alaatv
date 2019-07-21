<?php

namespace App\Http\Controllers\Api;

use App\Content;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Traits\Content\ContentControllerResponseTrait;

class ContentController extends Controller
{
    use ContentControllerResponseTrait;
    
    public function show(Request $request, Content $content)
    {
        if (!$content->isActive()) {
            $message = '';
            $code    = Response::HTTP_LOCKED;
            return response()->json([
                'message' => $message,
            ], $code);
        }
    
        if ($this->userCanSeeContent($request, $content, 'api')) {
            return response()->json($content, Response::HTTP_OK);
        }
    
        $productsThatHaveThisContent = $content->activeProducts();
    
        return $this->getUserCanNotSeeContentJsonResponse($content, $productsThatHaveThisContent, function ($msg) {
        });
    }

    public function fetchVideos(Request $request){
        $videos = Content::valid()->where('contenttype_id' , config('constants.CONTENT_TYPE_VIDEO'));
        return $videos->paginate(25, ['*'], 'page');
    }
}
