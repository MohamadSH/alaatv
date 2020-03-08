<?php

namespace App\Http\Controllers\Api;

use App\Classes\Search\ContentSearch;
use App\Content;
use App\Contenttype;
use App\Http\Controllers\Controller;
use App\Http\Resources\Content as ContentResource;
use App\Http\Resources\ContentInSet;
use App\Traits\Content\ContentControllerResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class ContentController extends Controller
{
    use ContentControllerResponseTrait;

    public function index(Request $request, ContentSearch $contentSearch)
    {
        $request->offsetSet('free', $request->get('free', [1]));
        $contentTypes = array_filter($request->get('contentType', Contenttype::video()));
        $filters      = $request->all();

        $result = $contentSearch->get(compact('filters', 'contentTypes'));
        return ContentInSet::collection($result->get($contentTypes[0]));
    }


    public function show(Request $request, Content $content)
    {
        if (!is_null($content->redirectUrl)) {
            return redirect(convertRedirectUrlToApiVersion($content->redirectUrl),
                Response::HTTP_FOUND, $request->headers->all());
        }

        if (!$content->isActive()) {
            $message = '';
            $code    = Response::HTTP_LOCKED;
            return response()->json([
                'message' => $message,
            ], $code);
        }

        if ($this->userCanSeeContent($request, $content, 'api')) {
            return response()->json($content);
        }

        $productsThatHaveThisContent = $content->activeProducts();

        return $this->getUserCanNotSeeContentJsonResponse($content, $productsThatHaveThisContent, function ($msg) {
        });
    }

    /**
     * API Version 2
     *
     * @param Request $request
     * @param Content $content
     *
     * @return ContentResource|JsonResponse|RedirectResponse|Redirector
     */
    public function showV2(Request $request, Content $content)
    {
        $user = $request->user('api');
        if (!is_null($content->redirectUrl)) {
            return redirect(convertRedirectUrlToApiVersion($content->redirectUrl, '2'),
                Response::HTTP_FOUND, $request->headers->all());
        }

        if (!$content->isActive()) {
            return response()->json(Response::HTTP_LOCKED);
        }

        $content->canSeeContent = 0; //can't see content
        if(!isset($user)) {
            $content->canSeeContent = 2; //it's not determine whether can see content or not
        }elseif($this->userCanSeeContent($request, $content, 'api')){
            $content->canSeeContent = 1; //can see content
        }

        return (new ContentResource($content));
    }

    public function fetchContents(Request $request)
    {
        $since = $request->get('timestamp');

        $contents = Content::active()->free()->type(config('constants.CONTENT_TYPE_VIDEO'));
        if ($since !== null) {
            $contents->where(function ($q) use ($since) {
                $q->where('created_at', '>=', Carbon::createFromTimestamp($since))
                    ->orWhere('updated_at', '>=', Carbon::createFromTimestamp($since));
            });
        }
        $contents->orderBy('created_at', 'DESC');
        $contents = $contents->paginate(25, ['*'], 'page');

        $items = [];
        foreach ($contents as $key => $content) {
            $items[$key]['id']    = $content->id;
            $items[$key]['type']  = 'content';
            $items[$key]['name']  = $content->name;
            $items[$key]['link']  = $content->url;
            $items[$key]['image'] = $content->thumbnail;
            $items[$key]['tags']  = $content->tags;
        }

        $currentPage = $contents->currentPage();
        $nextPageUrl = null;
        if ($currentPage < 40) {
            $nextPageUrl = $contents->nextPageUrl();
        }

        $contents->appends([$request->input()]);
        $pagination = [
            'current_page'  => $currentPage,
            'next_page_url' => $nextPageUrl,
            'last_page'     => 40,
            'data'          => $items,
        ];

        return response()->json($pagination, Response::HTTP_OK, [], JSON_UNESCAPED_SLASHES);
    }
}
