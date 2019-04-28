<?php

namespace App\Http\Controllers\Api;

use App\Collection\ProductCollection;
use App\Content;
use App\Http\Controllers\Controller;
use App\Traits\Content\ContentControllerResponseTrait;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContentController extends Controller
{
    use ContentControllerResponseTrait;
    
    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @param  Content  $content
     *
     * @return Response
     */
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
                Response::HTTP_FORBIDDEN,$productsThatHaveThisContent,true);
            
        }
        return $this->userCanNotSeeContentResponse(trans('content.Not Free') ,
            Response::HTTP_FORBIDDEN,$productsThatHaveThisContent,true);
    }
    
}
