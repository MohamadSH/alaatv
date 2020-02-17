<?php

namespace App\Http\Controllers\Api;

use App\Classes\Search\ContentsetSearch;
use App\Contentset;
use App\Http\Controllers\Controller;
use App\Http\Resources\SetInIndex;
use App\Http\Resources\SetWithoutPagination;
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

    public function showV2(Request $request, Contentset $set)
    {
        if (!is_null($set->redirectUrl)) {
            return redirect(convertRedirectUrlToApiVersion($set->redirectUrl, '2'),
                Response::HTTP_FOUND, $request->headers->all());
        }

        return new SetWithoutPagination($set);
    }

    public function index(Request $request, ContentsetSearch $contentSearch)
    {
        $setFilters            = $request->all();
        $setFilters['enable']  = 1;
        $setFilters['display'] = 1;
        $setResult             = $contentSearch->get($setFilters);

        return SetInIndex::collection($setResult);
    }
}
