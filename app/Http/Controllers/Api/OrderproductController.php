<?php

namespace App\Http\Controllers\Api;

use App\Collection\OrderproductCollection;
use App\Product;
use App\Traits\OrderCommon;
use App\Traits\ProductCommon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class OrderproductController extends Controller
{
    use OrderCommon;
    use ProductCommon;

    private $orderproductController;

    function __construct(\App\Http\Controllers\Web\OrderproductController $orderproductController)
    {
        $this->middleware(['CheckPermissionForSendOrderId',], ['only' => ['store'],]);
        $this->orderproductController = $orderproductController;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->has('extraAttribute')) {
            if (!$request->user()->can(config("constants.ATTACH_EXTRA_ATTRIBUTE_ACCESS"))) {
                $productId = $request->get('product_id');
                $product = Product::findOrFail($productId);
                $attributesValues = $this->orderproductController->getAttributesValuesFromProduct($request, $product);
                $this->orderproductController->syncExtraAttributesCost($request, $attributesValues);
                $request->offsetSet('parentProduct', $product);
            }
        }

        $result = $this->orderproductController->new($request->all());
        $orderproducts = new OrderproductCollection();
        if(isset($result['data']['storedOrderproducts']))
            $orderproducts = $result['data']['storedOrderproducts'];

        return response($orderproducts , Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
