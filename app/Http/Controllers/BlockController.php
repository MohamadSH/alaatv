<?php

namespace App\Http\Controllers;

use App\Block;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BlockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Block[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $blocks = Block::getBlocks();
        return ($request->expectsJson() ? response()->json($blocks) : $blocks);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param  \App\Block $block
     * @return Block|\Illuminate\Http\JsonResponse
     */
    public function show(Request $request, Block $block)
    {
        return ($request->expectsJson() ? response()->json($block) : $block);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Block $block
     * @return \Illuminate\Http\Response
     */
    public function edit(Block $block)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Block $block
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Block $block)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Block $block
     * @return \Illuminate\Http\Response
     */
    public function destroy(Block $block)
    {
        //
    }
}
