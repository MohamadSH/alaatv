<?php

namespace App\Http\Controllers\Api;

use App\Content;
use App\Http\Controllers\Controller;
use App\Http\Resources\FAQ;
use App\Http\Resources\User as UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;


class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['satra', 'bigUpload', 'faq']]);
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

    public function authTestV2(Request $request)
    {
        return (new UserResource($request->user()))->response();
    }

    public function satra()
    {
        $contents = Cache::tags(['satra'])->remember('satra_api', config('constants.CACHE_60'), function () {
            return Content::query()
                ->orderByDesc('created_at')
                ->where('contenttype_id', config('constants.CONTENT_TYPE_VIDEO'))
                ->active()
                ->limit(5)
                ->get();
        });

        $contentArray = [];
        foreach ($contents as $content) {
            $validSince     = $content->ValidSince_Jalali(false);
            $createdAt      = $content->CreatedAt_Jalali();
            $contentArray[] = [
                'id'           => $content->id,
                'url'          => $content->url,
                'title'        => $content->name,
                'published_at' => isset($validSince) ? $validSince : $createdAt,
                'visit_count'  => 0,
            ];
        }

        return response()->json($contentArray);
    }

    public function faq()
    {
        return FAQ::collection(collect(alaaSetting()->faq));
    }
}
