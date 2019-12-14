<?php

namespace App\Http\Controllers\Api;

use App\Block;
use App\Http\Resources\Block as BlockResource;
use App\Slideshow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShopPageController extends Controller
{

    public function __invoke(Request $request)
    {
        $url = $request->url();
        $slides = Slideshow::getShopBanner();
        $blocks = Block::getShopBlocksForApp();
        $numberOfBlocks = $blocks->count();
        return response()->json([
            'mainBanner' => $slides->isNotEmpty() ? $slides : null,
            'block'      => [
                'current_page'   => 1,
                'data'           => BlockResource::collection($blocks),
                'first_page_url' => null,
                'from'           => 1,
                'last_page'      => 1,
                'last_page_url'  => null,
                'next_page_url'  => null,
                'path'           => $url,
                'per_page'       => $numberOfBlocks + 1,
                'prev_page_url'  => null,
                'to'             => $numberOfBlocks,
                'total'          => $numberOfBlocks,
            ],
        ]);
    }
}
