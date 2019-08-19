<?php

namespace App\Http\Controllers\Api;

use App\Content;
use App\Contentset;
use App\Product;
use Carbon\Carbon;
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
            return response()->json($content);
        }

        $productsThatHaveThisContent = $content->activeProducts();

        return $this->getUserCanNotSeeContentJsonResponse($content, $productsThatHaveThisContent, function ($msg) {
        });
    }

    public function fetchSets(Request $request){
        $since = $request->get('timestamp');

        $sets = Contentset::active()->display();
        if(!is_null($since)){
            $sets->where(function($q) use ($since){
                $q->where('created_at' , '>=' , Carbon::createFromTimestamp($since))
                    ->orWhere('updated_at' , '>=' , Carbon::createFromTimestamp($since));
            });
        }
        $sets = $sets->paginate(25, ['*'], 'page');

        $items = [];
        foreach ($sets as $key=>$set) {
            $items[$key]['id'] = $set->id;
            $items[$key]['type'] = 'set';
            $items[$key]['name'] = $set->name;
            $items[$key]['link'] = $set->url;
            $items[$key]['image'] = $set->photo;
            $items[$key]['tags'] = $set->tags;
        }

        $sets->appends([$request->input()]);
        $pagination = [
            'current_page'    => $sets->currentPage(),
            'next_page_url'   => $sets->nextPageUrl(),
            'last_page'       => $sets->lastPage(),
            'data'            => $items,
        ];

        return response()->json($pagination,Response::HTTP_OK , [] ,JSON_UNESCAPED_SLASHES);
    }
}
