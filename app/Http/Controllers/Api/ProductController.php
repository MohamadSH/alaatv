<?php

namespace App\Http\Controllers\Api;

use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\ProductCommon;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Collection\ProductCollection;
use Illuminate\Support\Facades\Cache;
use \App\Http\Resources\Product as ProductResource;

class ProductController extends Controller
{
    use ProductCommon;

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Product $product
     *
     * @return Response
     */
    public function show(Request $request, Product $product)
    {
        if($product->id == 385){
            return redirect( route('api.v1.product.show' , Product::RAHE_ABRISHAM ),
                Response::HTTP_FOUND, $request->headers->all());
        }

        if (!is_null($product->redirectUrl)) {
            return redirect(convertRedirectUrlToApiVersion($product->redirectUrl),
                Response::HTTP_FOUND, $request->headers->all());
        }

        if (!is_null($product->grandParent)) {
            return redirect($product->grandParent->apiUrl['v1'], Response::HTTP_MOVED_PERMANENTLY,
                $request->headers->all());
        }

        return response()->json($product);
    }

    public function showV2(Request $request , Product $product)
    {
        if (!is_null($product->redirectUrl)) {
            return redirect(convertRedirectUrlToApiVersion($product->redirectUrl),
                Response::HTTP_FOUND, $request->headers->all());
        }

        if (!is_null($product->grandParent)) {
            return redirect($product->grandParent->apiUrl['v1'], Response::HTTP_MOVED_PERMANENTLY,
                $request->headers->all());
        }

        return (new ProductResource($product))->response();
    }

    /**
     *
     *
     * @param Request $request
     * @param  Product                   $grandProduct
     *
     * @return Response
     */
    public function refreshPrice(Request $request, Product $grandProduct)
    {
        $mainAttributeValues   = $request->get('mainAttributeValues');
        $selectedSubProductIds = $request->get('products');
        $extraAttributeValues  = $request->get('extraAttributeValues');

        $user = $request->user('alaatv');

        $key = 'product:refreshPrice:'.$grandProduct->cacheKey()."-user\\".(isset($user) && !is_null($user) ? $user->cacheKey() : '')."-mainAttributeValues\\".(isset($mainAttributeValues) ? implode('',
                $mainAttributeValues) : '-')."-subProducts\\".(isset($selectedSubProductIds) ? implode('',
                $selectedSubProductIds) : '-')."-extraAttributeValues\\".(isset($extraAttributeValues) ? implode('',
                $extraAttributeValues) : '-');

        return Cache::tags('bon')
            ->remember($key, config('constants.CACHE_60'), function () use (
                $grandProduct,
                $user,
                $mainAttributeValues,
                $selectedSubProductIds,
                $extraAttributeValues
            ) {
                $grandProductType = optional($grandProduct->producttype)->id;
                $intendedProducts = collect();
                switch ($grandProductType) {
                    case config('constants.PRODUCT_TYPE_SIMPLE'):
                        $intendedProducts->push($grandProduct);
                        break;
                    case config('constants.PRODUCT_TYPE_CONFIGURABLE'):
                        $simpleProduct = $this->findProductChildViaAttributes($grandProduct, $mainAttributeValues);
                        if (isset($simpleProduct)) {
                            $intendedProducts->push($simpleProduct);
                        }

                        break;
                    case config('constants.PRODUCT_TYPE_SELECTABLE'):
                        if (isset($selectedSubProductIds)) {
                            /** @var ProductCollection $selectedSubProducts */
                            $selectedSubProducts = Product::whereIn('id', $selectedSubProductIds)
                                ->get();
                            $selectedSubProducts->load('parents');
                            $selectedSubProducts->keepOnlyParents();

                            $intendedProducts = $selectedSubProducts;
                        }
                        break;
                    default :
                        break;
                }

                $cost            = 0;
                $costForCustomer = 0;
                $outOfStocks     = collect();
                $error           = false;
                if ($intendedProducts->isNotEmpty()) {
                    foreach ($intendedProducts as $product) {
                        if ($product->isInStock()) {
                            if (isset($user)) {
                                $costArray = $product->calculatePayablePrice($user);
                            }
                            else {
                                $costArray = $product->calculatePayablePrice();
                            }

                            $cost            += $costArray['cost'];
                            $costForCustomer += $costArray['customerPrice'];
                        }
                        else {
                            $outOfStocks->push([
                                'id'   => $product->id,
                                'name' => $product->name,
                            ]);
                        }
                    }
                }
                else {
                    $error     = true;
                    $errorCode = Response::HTTP_NOT_FOUND;
                    $errorText = 'No products found';
                }

                $totalExtraCost = 0;
                if (is_array($extraAttributeValues)) {
                    $totalExtraCost = $this->productExtraCostFromAttributes($grandProduct, $extraAttributeValues);
                }

                if ($error) {
                    $result = [
                        'error' => [
                            'code'    => $errorCode ?? $errorCode,
                            'message' => $errorText ?? $errorText,
                        ],
                    ];
                }
                else {
                    $result = [
                        'outOfStock' => $outOfStocks->isEmpty() ? null : $outOfStocks,
                        'cost'       => [
                            'base'     => $cost,
                            'discount' => $cost - $costForCustomer,
                            'final'    => $costForCustomer + $totalExtraCost,
                        ],
                    ];
                }

                return json_encode($result, JSON_UNESCAPED_UNICODE);
            });
    }

    public function fetchProducts(Request $request){
        $since = $request->get('timestamp');

        $products = Product::active()->whereNull('grand_id');
        if(!is_null($since)){
            $products->where(function($q) use ($since){
                    $q->where('created_at' , '>=' , Carbon::createFromTimestamp($since))
                        ->orWhere('updated_at' , '>=' , Carbon::createFromTimestamp($since));
            });
        }
        $products = $products->paginate(25, ['*'], 'page');

        $items = [];
        foreach ($products as $key=>$product) {
            $items[$key]['id'] = $product->id;
            $items[$key]['type'] = 'product';
            $items[$key]['name'] = $product->name;
            $items[$key]['link'] = $product->url;
            $items[$key]['image'] = $product->photo;
            $items[$key]['tags'] = $product->tags;
        }

        $products->appends([$request->input()]);
        $pagination = [
          'current_page'    => $products->currentPage(),
          'next_page_url'   => $products->nextPageUrl(),
          'last_page'       => $products->lastPage(),
          'data'            => $items,
        ];

        return response()->json($pagination,Response::HTTP_OK , [] ,JSON_UNESCAPED_SLASHES);
    }
}
