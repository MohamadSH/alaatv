<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api' , ['except'=>['satra']]);
    }

    public function debug(Request $request)
    {
        return response()->json([
            'user'  => $request->user(),
            'debug' => 2,
        ]);
    }

    public function authTest(Request $request)
    {
        return response()->json([
            'User' => $request->user(),
        ]);
    }

    public function satra()
    {
        $contents = \App\Content::active()
                                ->orderByDesc('created_at')
                                ->where('contenttype_id' , config('constants.CONTENT_TYPE_VIDEO'))
                                ->limit(5)
                                ->get();

        $contentArray = [];
        foreach ($contents as $content) {
            $validSince = $content->ValidSince_Jalali(false);
            $createdAt  = $content->CreatedAt_Jalali();
            $contentArray[] = [
                'id'            => $content->id,
                'url'           => $content->url,
                'title'         => $content->name,
                'published_at'  => isset($validSince)?$validSince:$createdAt,
                'visit_count'  => 0
            ];
        }

        return response()->json($contentArray);
    }
}
