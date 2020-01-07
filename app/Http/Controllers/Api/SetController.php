<?php

namespace App\Http\Controllers\Api;

use App\Classes\Search\ContentsetSearch;
use App\Contentset;
use App\Http\Controllers\Controller;
use App\Http\Resources\SetInIndex as SetResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SetController extends Controller
{
    public function show(Request $request, Contentset $set)
    {
        if (!is_null($set->redirectUrl)) {
            return redirect(convertRedirectUrlToApiVersion($set->redirectUrl),
                Response::HTTP_FOUND, $request->headers->all());
        }

        return response()->json($set);
    }

    /**
     * API Version 2
     *
     * @param Request    $request
     * @param Contentset $set
     *
     * @return SetResource|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function showV2(Request $request, Contentset $set)
    {
        if (!is_null($set->redirectUrl)) {
            return redirect(convertRedirectUrlToApiVersion($set->redirectUrl),
                Response::HTTP_FOUND, $request->headers->all());
        }

        return (new SetResource($set));
    }

    public function index(Request $request, ContentsetSearch $contentSearch)
    {
        $setFilters            = $request->all();
        $setFilters['enable']  = 1;
        $setFilters['display'] = 1;
        $setResult             = $contentSearch->get($setFilters);

        return SetResource::collection($setResult);
    }
}
