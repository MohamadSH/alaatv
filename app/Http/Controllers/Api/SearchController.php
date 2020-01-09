<?php

namespace App\Http\Controllers\Api;

use App\Classes\Search\ContentSearch;
use App\Classes\Search\ContentsetSearch;
use App\Classes\Search\ProductSearch;
use App\Contenttype;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContentIndexRequest;
use App\Http\Resources\ContentInSet;
use App\Http\Resources\ProductInBlock;
use App\Http\Resources\SetInIndex;
use Illuminate\Http\JsonResponse;

class SearchController extends Controller
{
    /**
     * @param ContentIndexRequest $request
     *
     * @param ContentSearch       $contentSearch
     * @param ContentsetSearch    $setSearch
     * @param ProductSearch       $productSearch
     *
     * @return JsonResponse
     */
    public function index(ContentIndexRequest $request, ContentSearch $contentSearch, ContentsetSearch $setSearch, ProductSearch $productSearch)
    {
        $request->offsetSet('free', $request->get('free', [1]));
        $contentTypes = array_filter($request->get('contentType', Contenttype::video()));
        $contentOnly  = $request->get('contentOnly', false);
        $tags         = (array)$request->get('tags');
        $filters      = $request->all();

        $videos = $contentSearch->get(compact('filters', 'contentTypes'))->get('video');
        $videos = isset($videos) && $videos->count() > 0 ? ContentInSet::collection($videos) : null;

        $setFilters            = $filters;
        $setFilters['enable']  = 1;
        $setFilters['display'] = 1;
        $sets                  = $setSearch->get($setFilters);
        $sets                  =
            !$contentOnly && isset($sets) && $sets->count() > 0 ? SetInIndex::collection($sets) : null;

        $productFilters                    = $filters;
        $productFilters['active']          = 1;
        $productFilters['doesntHaveGrand'] = 1;
        $products                          = $productSearch->get($productFilters);

        $products =
            !$contentOnly && isset($products) && $products->count() > 0 ? ProductInBlock::collection($products) : null;

        return response()->json([
            'data' => [
                'videos'    => $videos,
                'products'  => $products,
                'sets'      => $sets,
                'tags'      => empty($tags) ? null : $tags,
            ],
        ]);
    }
}
