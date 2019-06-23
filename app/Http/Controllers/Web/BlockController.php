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
        // $contents = Content::all();
        $blockSets = $block->sets()->get();
        $blockContents = $block->contents()->get();
        $blockProductsId = $block->products()->get()->pluck('id');
        return view('block.edit', compact(['block', 'products', 'sets', 'blockSets', 'blockContents', 'blockProductsId', 'blockTypes']));
    }
    
    public function update(Request $request, Block $block)
    {
        $productsId = $request->get('block-products');
        $setsId = $request->get('block-sets');
        $contentsId =convertTagStringToArray($request->get('contents'));
        $tags =convertTagStringToArray($request->get('tags'));
    
        $productsId = isset($productsId) ? $productsId : [];
        $contentsId = isset($contentsId) ? $contentsId : [];
        $setsId = isset($setsId) ? $setsId : [];
        
        $this->fillBlock($request, $block, $tags);
        
        $block->update();
        
        $this->attachProducts($block, $productsId);
    
        $this->attachSets($block, $setsId);
    
        $this->attachContents($block, $contentsId);
    
        session()->put('success', 'اصلاح بلاک با موفقیت انجام شد');
        
        return redirect()->back();
    }
    
    /**
     * @param  Block  $block
     * @param  array  $productsId
     */
    public function attachProducts(Block $block, array $productsId): void
    {
        $block->products()->detach();
        $block->products()->saveMany(Product::whereIn('id', $productsId)->get());
    }
    
    /**
     * @param  Block  $block
     * @param  array  $setsId
     */
    public function attachSets(Block $block, array $setsId): void
    {
        $block->sets()->detach();
        $block->sets()->saveMany(Contentset::whereIn('id', $setsId)->get());
    }
    
    /**
     * @param  Block  $block
     * @param  array  $contentsId
     */
    public function attachContents(Block $block, array $contentsId): void
    {
        $block->contents()->detach();
        $block->contents()->saveMany(Content::whereIn('id', $contentsId)->get());
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
    
    /**
     * @param  Request  $request
     * @param  Block    $block
     * @param  array    $tags
     */
    private function fillBlock(Request $request, Block $block, array $tags): void
    {
        $block->title     = $request->get('title');
        $block->customUrl = $request->get('customUrl');
        $block->class     = $request->get('class');
        $block->order     = $request->get('order');
        $block->enable    = $request->get('enable');
        $block->type      = $request->get('type');
        $block->tags      = json_encode($tags);
    }
    
    public function detachFromBlock(Block $block, string $type, int $id) {
        $detachType = [
            'product' => 'detachProduct',
            'set' => 'detachSet',
            'content' => 'detachContent'
        ];
        $methodName = $detachType[$type];
        $this->$methodName($block, $id);
        return redirect()->back();
    }
    
    private function detachProduct(Block $block, int $id) {
        $block->products()->detach(Product::find($id));
    }
    
    private function detachSet(Block $block, int $id) {
        $block->sets()->detach(Contentset::find($id));
    }
    
    private function detachContent(Block $block, int $id) {
        $block->contents()->detach(Content::find($id));
    }
}
