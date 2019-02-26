<?php

namespace App\Http\Controllers\Api;

use App\Collection\ProductCollection;
use App\Http\Controllers\Controller;
use App\Product;
use App\Traits\ProductCommon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    use ProductCommon;

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Product             $product
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Product $product)
    {
        if (!is_null($product->redirectUrl))
            return redirect($this->convertRedirectUrlToApiVersion($product->redirectUrl), Response::HTTP_MOVED_PERMANENTLY, $request->headers->all());

        if (!is_null($product->grandParent))
            return redirect($product->grandParent->apiUrl['v1'], Response::HTTP_MOVED_PERMANENTLY, $request->headers->all());

        return response()->json($product);
    }

    /**
     *
     *
     * @param \Illuminate\Http\Request $request
     * @param Product $product
     *
     * @return \Illuminate\Http\Response
     */
    public function refreshPrice(Request $request, Product $product)
    {
        $mainAttributeValues = $request->get("mainAttributeValues");
        $selectedSubProductIds = $request->get("products");
        $extraAttributeValues = $request->get("extraAttributeValues");

        $user = $request->user('api');
        if(!isset($user))
            $user = $request->user();
        //ToDo : Should have a route in web\ProductController

        $key = "product:refreshPrice:"
            . $product->cacheKey()
            . "-user\\"
            . (isset($user) && !is_null($user) ? $user->cacheKey() : "")
            . "-mainAttributeValues\\"
            . (isset($mainAttributeValues) ? implode("", $mainAttributeValues) : "-")
            . "-subProducts\\"
            . (isset($selectedSubProductIds) ? implode("", $selectedSubProductIds) : "-")
            . "-extraAttributeValues\\"
            . (isset($extraAttributeValues) ? implode("", $extraAttributeValues) : "-");

        return Cache::tags('bon')
            ->remember($key, config("constants.CACHE_60"), function () use ($product, $user, $mainAttributeValues, $selectedSubProductIds, $extraAttributeValues) {
                $productType = optional($product->producttype)->id;
                $intendedProducts = collect();
                switch ($productType) {
                    case config("constants.PRODUCT_TYPE_SIMPLE"):
                        $intendedProducts->push($product);
                        break;
                    case config("constants.PRODUCT_TYPE_CONFIGURABLE"):
                        $simpleProduct = $this->findProductChildViaAttributes($product, $mainAttributeValues);
                        if (isset($simpleProduct)) {
                            $intendedProducts->push($simpleProduct);
                        }

                        break;
                    case config("constants.PRODUCT_TYPE_SELECTABLE"):
                        if (isset($selectedSubProductIds)) {
                            /** @var ProductCollection $selectedSubProducts */
                            $selectedSubProducts = Product::whereIn('id', $selectedSubProductIds)->get();
                            $selectedSubProducts->load('parents');
                            $selectedSubProducts->keepOnlyParents();

                            $intendedProducts = $selectedSubProducts;
                        }
                        break;
                    default :
                        break;
                }

                $cost = 0;
                $costForCustomer = 0;
                $outOfStocks = collect();
                $error = false;
                if($intendedProducts->isNotEmpty())
                {
                    foreach ($intendedProducts as $product) {
                        if ($product->isInStock()) {
                            if (isset($user))
                                $costArray = $product->calculatePayablePrice($user);
                            else
                                $costArray = $product->calculatePayablePrice();

                            $cost += $costArray["cost"];
                            $costForCustomer += $costArray["customerPrice"];
                        }else{
                            $outOfStocks->push([
                                    'id'    => $product->id,
                                    'name'  => $product->name
                                ]
                            );
                        }
                    }
                }else{
                    $error     = true;
                    $errorCode = Response::HTTP_NOT_FOUND;
                    $errorText = 'No products found' ;
                }

                $totalExtraCost = 0;
                if (is_array($extraAttributeValues))
                    $totalExtraCost = $this->productExtraCostFromAttributes($product, $extraAttributeValues);

                if($error)
                {
                    $result = [
                        'error' =>  [
                            'code' => $errorCode??$errorCode,
                            'message' => $errorText??$errorText
                        ]
                    ];
                }else{
                    $result = [
                        'outOfStock'=> $outOfStocks->isEmpty()? null : $outOfStocks ,
                        'cost'      => [
                            'base'      => $cost ,
                            'discount'  => $cost - $costForCustomer,
                            'final'     => $costForCustomer + $totalExtraCost
                        ]
                    ];
                }

                return json_encode($result, JSON_UNESCAPED_UNICODE);
            });

    }


    private function convertRedirectUrlToApiVersion($url)
    {
        $url = parse_url($url);
        return url('/api/v1' . $url['path']);
    }

}
