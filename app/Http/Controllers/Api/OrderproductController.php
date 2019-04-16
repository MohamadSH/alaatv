<?php

namespace App\Http\Controllers\Api;

use App\Collection\OrderproductCollection;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderProduct\OrderProductStoreRequest;
use App\Orderproduct;
use App\Product;
use App\Traits\OrderCommon;
use App\Traits\ProductCommon;
use Cache;
use Illuminate\Http\Request;
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
     * @param \App\Http\Requests\OrderProduct\OrderProductStoreRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(OrderProductStoreRequest $request)
    {
        if ($request->has('extraAttribute')) {
            if (! $request->user()->can(config("constants.ATTACH_EXTRA_ATTRIBUTE_ACCESS"))) {
                $productId = $request->get('product_id');
                $product = Product::findOrFail($productId);
                $attributesValues = $this->orderproductController->getAttributesValuesFromProduct($request, $product);
                $this->orderproductController->syncExtraAttributesCost($request, $attributesValues);
                $request->offsetSet('parentProduct', $product);
            }
        }

        $result = $this->orderproductController->new($request->all());
        $orderproducts = new OrderproductCollection();
        if (isset($result['data']['storedOrderproducts'])) {
            $orderproducts = $result['data']['storedOrderproducts'];
        }

        return response($orderproducts, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Orderproduct $orderproduct
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, Orderproduct $orderproduct)
    {
        $authenticatedUser = $request->user('api');
        $orderUser = optional(optional($orderproduct)->order)->user;

        if ($authenticatedUser->id != $orderUser->id) {
            abort(Response::HTTP_FORBIDDEN, 'Orderproduct does not belong to this user.');
        }

        $orderproduct_userbons = $orderproduct->userbons;
        foreach ($orderproduct_userbons as $orderproduct_userbon) {
            $orderproduct_userbon->usedNumber = $orderproduct_userbon->usedNumber - $orderproduct_userbon->pivot->usageNumber;
            $orderproduct_userbon->userbonstatus_id = config("constants.USERBON_STATUS_ACTIVE");
            if ($orderproduct_userbon->usedNumber >= 0) {
                $orderproduct_userbon->update();
            }
        }

        if ($orderproduct->delete()) {
            foreach ($orderproduct->children as $child) {
                $child->delete();
            }
            Cache::tags('bon')->flush();

            return response([
                'message' => 'Orderproduct removed successfully',
            ], Response::HTTP_OK);
        } else {
            return response([
                'message' => 'Database error on removing orderproduct',
            ], Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }
}
