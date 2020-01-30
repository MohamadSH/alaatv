<?php

namespace App\Http\Middleware;

use App\Product;
use App\Traits\OrderproductTrait;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CheckPermissionForSendExtraAttributesCost
{
    use OrderproductTrait;

    private $user;

    /**
     * OrderCheck constructor.
     *
     * @param Request         $request
     */
    public function __construct(Request $request)
    {
        $this->user = $request->user();
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
}
