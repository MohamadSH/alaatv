<?php

namespace App\Http\Controllers\Web;

use App\Block;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlockController extends Controller
{
    public function index(Request $request)
    {
        $blocks = Block::getMainBlocks();
        
        return ($request->expectsJson() ? response()->json($blocks) : $blocks);
    }
    
    public function adminIndex(Request $request)
    {
        $perPage = ($request->has('length')) ? $request->get('length') : 10;
        $blocks = Block::paginate($perPage);
        return $blocks;
    }
    
    public function adminBlock(Request $request)
    {
        $pageName = 'indexBlock';
        return view('admin.indexBlock', compact(['pageName']));
    }
    
    public function show(Request $request, Block $block)
    {
        return ($request->expectsJson() ? response()->json($block) : $block);
    }
    
    public function edit(Request $request, Block $block)
    {
        return $block;
        return view('block.edit', compact(['block']));
    }
    
    public function store(Request $request)
    {
    }
}
