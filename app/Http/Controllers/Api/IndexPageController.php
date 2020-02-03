<?php

namespace App\Http\Controllers\Api;

use App\Block;
use App\Classes\Format\BlockCollectionFormatter;
use App\Http\Controllers\Controller;
use App\Http\Resources\BlockV2;
use Illuminate\Http\Request;

class IndexPageController extends Controller
{
    public function __invoke(Request $request, BlockCollectionFormatter $blockCollectionFormatter)
    {
        return BlockV2::collection(Block::getMainBlocksForAppV2());
    }
}
