<?php

namespace App\Http\Controllers\Api;

use App\Block;
use Illuminate\Http\Request;
use App\Http\Resources\BlockV2;
use App\Http\Controllers\Controller;
use App\Classes\Format\BlockCollectionFormatter;

class IndexPageController extends Controller
{
    public function __invoke(Request $request, BlockCollectionFormatter $blockCollectionFormatter)
    {
        return BlockV2::collection(Block::getMainBlocksForAppV2());
    }
}
