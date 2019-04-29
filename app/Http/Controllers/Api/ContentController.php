<?php

namespace App\Http\Controllers\Api;

use App\Content;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContentController extends Controller
{
    public function show(Request $request, Content $content)
    {
        if (!$content->isActive()) {
            return response()->json([
                'message' => "",
            ], Response::HTTP_LOCKED);
        }
        
        if ($this->userCanSeeContent($request, $content)) {
            return response()->json($content, Response::HTTP_OK);
        }
        
        $productsThatHaveThisContent = $content->products();
        
        return response()->json([
            'message' => trans('content.Not Free'),
            'product' => $productsThatHaveThisContent->isEmpty() ? null : $productsThatHaveThisContent,
        ], Response::HTTP_FORBIDDEN);
    }
    
    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Content              $content
     *
     * @return bool
     */
    private function userCanSeeContent(Request $request, Content $content): bool
    {
        return $content->isFree || optional($request->user('api'))->hasContent($content);
    }
}
