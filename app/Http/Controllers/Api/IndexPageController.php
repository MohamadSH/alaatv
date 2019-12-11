<?php

namespace App\Http\Controllers\Api;

use App\Block;
use App\Classes\Format\BlockCollectionFormatter;
use App\Http\Resources\Block as BlockResource;
use App\Http\Resources\BlockCollection;
use App\Slideshow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexPageController extends Controller
{
    public function __invoke(Request $request, BlockCollectionFormatter $blockCollectionFormatter)
    {
        return new BlockCollection(Block::getMainBlocksForApp());
    }
}
