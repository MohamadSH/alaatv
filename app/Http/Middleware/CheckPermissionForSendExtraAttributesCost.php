<?php

namespace App\Http\Middleware;

use App\Http\Controllers\OrderController;
use App\Product;
use Closure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CheckPermissionForSendExtraAttributesCost
{
    /**
     * @var OrderController
     */
    private $orderController;

    private $user;

    /**
     * OrderCheck constructor.
     *
     * @param Request         $request
     * @param OrderController $controller
     */
    public function __construct(Request $request, OrderController $controller)
    {
        $this->orderController = $controller;
        $this->user            = $request->user();
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param null    $guard
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (!Auth::guard($guard)->check()) {
            return response()->json(['error' => 'Unauthenticated',], Response::HTTP_UNAUTHORIZED);
        }

        if (!$request->has('extraAttribute') || $this->user->can(config("constants.ATTACH_EXTRA_ATTRIBUTE_ACCESS"))) {
            return $next($request);
        }

        $productId        = $request->get('product_id');
        $product          = Product::findOrFail($productId);
        $attributesValues = $this->getAttributesValuesFromProduct($request, $product);
        $this->syncExtraAttributesCost($request, $attributesValues);
        $request->offsetSet('parentProduct', $product);

        return $next($request);
    }

    /**
     * @param Request $request
     * @param Product $product
     *
     * @return Collection|null
     */
    private function getAttributesValuesFromProduct(Request $request, Product $product): ?Collection
    {
        $extraAttributes   = $request->get('extraAttribute');
        $extraAttributesId = array_column($extraAttributes, 'id');
        $attributesValues  = $product->getAttributesValueByIds($extraAttributesId);

        return $attributesValues;
    }

    /**
     * @param Request    $request
     * @param Collection $attributesValues
     */
    public function syncExtraAttributesCost(Request $request, Collection $attributesValues)
    {
        $extraAttributes = $request->get('extraAttribute');
        foreach ($attributesValues as $key => $attributesValue) {
            foreach ($extraAttributes as $key1 => $extraAttribute) {
                if ($extraAttribute['id'] == $attributesValue['id']) {
                    $extraAttributes[$key1]['cost']   = $attributesValue->pivot->extraCost;
                    $extraAttributes[$key1]['object'] = $attributesValue;
                }
            }
        }
        $request->offsetSet("extraAttribute", $extraAttributes);
    }
}
