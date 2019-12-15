<?php

namespace App\Http\Controllers\Api;

use App\Block;
use App\Http\Resources\BlockCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShopPageController extends Controller
{

    public function __invoke(Request $request)
    {
        return new BlockCollection(Block::getShopBlocksForAppV2());
    }
}
