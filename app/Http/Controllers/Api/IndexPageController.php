<?php

namespace App\Http\Controllers\Api;

use App\Block;
use App\Classes\Format\BlockCollectionFormatter;
use App\Http\Controllers\Controller;
use App\Http\Resources\BlockCollection;
use Illuminate\Http\Request;

class IndexPageController extends Controller
{
    public function __invoke(Request $request, BlockCollectionFormatter $blockCollectionFormatter)
    {
        return new BlockCollection(Block::getMainBlocksForApp());
    }
}
