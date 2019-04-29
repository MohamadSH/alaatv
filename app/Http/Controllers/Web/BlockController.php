<?php

namespace App\Http\Controllers\Web;

use App\Block;
use App\Classes\Format\BlockCollectionFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    /**
     * @var BlockCollectionFormatter
     */
    private $formatter;
    
    public function __construct(BlockCollectionFormatter $formatter)
    {
        $this->formatter = $formatter;
    }

    public function index(Request $request)
    {
        $blocks = Block::getMainBlocks();
        
        return ($request->expectsJson() ? response()->json($blocks) : $blocks);
    }

    public function show(Request $request, Block $block)
    {
        return ($request->expectsJson() ? response()->json($block) : $block);
    }
}
