<?php

namespace App\Http\Controllers\Web;

use App\Block;
use App\Http\Requests\SaveNewBlockRequest;
use App\Product;
use App\Content;
use App\Contentset;
use App\Traits\ProductCommon;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Jenssegers\Agent\Agent;

class BlockController extends Controller
{


    use ProductCommon;

    /**
     * BlockController constructor.
     * @param Agent $agent
     */
    public function __construct(Agent $agent)
    {
        $authException = $this->getAuthExceptionArray($agent);
        $this->callMiddlewares($authException);
    }

    /**
     * @param  Agent  $agent
     *
     * @return array
     */
    private function getAuthExceptionArray(Agent $agent): array
    {
        return [
            'show'
        ];
    }

    /**
     * @param  array  $authException
     */
    private function callMiddlewares(array $authException): void
    {
        $this->middleware('auth', ['except' => $authException]);
        $this->middleware('permission:'.config('constants.LIST_BLOCK_ACCESS'), ['only' => 'index']);
        $this->middleware('permission:'.config('constants.INSERT_BLOCK_ACCESS'), ['only' => 'store']);
        $this->middleware('permission:'.config('constants.REMOVE_BLOCK_ACCESS'), ['only' => 'destroy']);
        $this->middleware('permission:'.config('constants.EDIT_BLOCK_ACCESS'), ['only' => 'update']);
    }


    public function index(Request $request)
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
        $blockSets = $block->sets;
        $blockContents = $block->contents;
        $blockProductsId = $block->products->pluck('id');
        return view('block.edit', compact('block', 'products', 'sets', 'blockSets', 'blockContents', 'blockProductsId', 'blockTypes'));
    }
    
    public function update(Request $request, Block $block)
    {
        
        $productsId = $request->get('block-products' , []);
        $setsId = $request->get('block-sets' , []);
        $contentsId = convertTagStringToArray($request->get('contents' , ''));
    
        $this->fillBlockFromRequest($request, $block);
        
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
        $block->products()->sync($productsId);
    }
    
    /**
     * @param  Block  $block
     * @param  array  $setsId
     */
    public function attachSets(Block $block, array $setsId): void
    {
        $block->sets()->sync($setsId);
    }
    
    /**
     * @param  Block  $block
     * @param  array  $contentsId
     */
    public function attachContents(Block $block, array $contentsId): void
    {
        $block->contents()->sync($contentsId);
    }
    
    public function store(SaveNewBlockRequest $request)
    {
        $block = new Block();
        
        $productsId = $request->get('block-products' , []);
        $setsId = $request->get('block-sets' , []);
        $contentsId =convertTagStringToArray($request->get('contents' , ''));

        $this->fillBlockFromRequest($request, $block);
    
        if($block->save()) {
            $this->attachProducts($block, $productsId);

            $this->attachSets($block, $setsId);

            $this->attachContents($block, $contentsId);

            session()->put('success', 'ایجاد بلاک با موفقیت انجام شد');
            return redirect()->back();
        }

        session()->put('error', 'خطا در دخیره بلاک');
        return redirect()->back();

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
     */
    private function fillBlockFromRequest(Request $request, Block $block): void
    {
        $tags =convertTagStringToArray($request->get('tags'));
        $block->title     = $request->get('title');
        $block->customUrl = $request->get('customUrl');
        $block->class     = $request->get('class');
        $block->order     = $request->get('order');
        $block->enable    = $request->get('enable',0);
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
