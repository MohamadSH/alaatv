<?php

namespace App\Http\Controllers\Web;

use App\Block;
use App\Product;
use App\Content;
use App\Contentset;
use App\Traits\ProductCommon;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class BlockController extends Controller
{
    use ProductCommon;
    
    public function index(Request $request)
    {
        $blocks = Block::getMainBlocks();
        
        return ($request->expectsJson() ? response()->json($blocks) : $blocks);
    }
    
    public function adminIndex(Request $request)
    {
        $perPage = ($request->has('length')) ? $request->get('length') : 10;
        $blocks = Block::
        withCount('products')->
        withCount('sets')->
        withCount('contents')->
        withCount('banners')->
        paginate($perPage);
        $blocks->each(function ($items) {
            $items->append('editLink');
            $items->append('removeLink');
        });
        return $blocks;
    }
    
    public function show(Request $request, Block $block)
    {
        return ($request->expectsJson() ? response()->json($block) : $block);
    }
    
    public function edit(Request $request, Block $block)
    {
        //ToDo : put in view composer
        $blockTypes = [
            [
                'value' => '1',
                'name' => 'صفحه اصلی',
            ],
            [
                'value' => '2',
                'name' => 'فروشگاه',
            ],
            [
                'value' => '3',
                'name' => 'صفحه محصول',
            ]
        ];
        $products = $this->makeProductCollection();
        $sets = Contentset::all();
        $contents = Content::all();
        $blockSets = $block->sets()->get();
        $blockContents = $block->contents()->get();
        return view('block.edit', compact(['block', 'products', 'sets', 'blockSets', 'contents', 'blockContents', 'blockTypes']));
    }
    
    public function update(Request $request, Block $block)
    {
        $contents =convertTagStringToArray($request->get('contents'));
        $sets = $request->get('block-sets');
        $products = $request->get('block-products');
        dd($request->all());
//        $tags =convertTagStringToArray($request->get('tags'));
//        $block->title = $request->get('title');
//        $block->customUrl = $request->get('customUrl');
//        $block->class = $request->get('class');
//        $block->order = $request->get('order');
//        $block->enable = $request->get('enable');
//        $block->type = $request->get('type');
//        $block->tags = $tags;
//        $block->update();
    
//        $productArray = [
//            40, 35, 242, 232, 234, 240
//        ];
//        foreach ($productArray as $productId) {
//            $product = Product::find($productId);
//            $block->products()->save($product);
//        }
//        dd('$product saved');
    }
    
    private function checkArray($array) {
        if ($array === null || !is_array($array)) {
            return [];
        } else {
            return $array;
        }
    }
    
    public function store(Request $request)
    {
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  Response  $response
     * @param  Block     $block
     *
     * @return Response
     * @throws Exception
     */
    public function destroy(Response $response, Block $block)
    {
        $done = false;
        if ($block->delete()) {
            $done = true;
        }
        
        if ($done) {
            return $response->setStatusCode(Response::HTTP_OK);
        }
    
        return $response->setStatusCode(Response::HTTP_SERVICE_UNAVAILABLE);
    }
}
