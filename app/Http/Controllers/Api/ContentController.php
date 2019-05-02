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
            $message = "";
            $code    = Response::HTTP_LOCKED;
            return response()->json([
                'message' => $message,
            ], $code);
        }
        
        if ($this->userCanSeeContent($request, $content,'api')) {
            return response()->json($content, Response::HTTP_OK);
        }
        $productsThatHaveThisContent = $content->products();
        
        if ($productsThatHaveThisContent->isEmpty()) {
            return $this->userCanNotSeeContentResponse(trans('content.Not Free And you can\'t buy it') ,
                Response::HTTP_FORBIDDEN, $content);
            
        }
        return $this->userCanNotSeeContentResponse(trans('content.Not Free') ,
            Response::HTTP_FORBIDDEN, $content, $productsThatHaveThisContent, true);
    }
    
}
