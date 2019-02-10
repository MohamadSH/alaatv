<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
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
        if (isset($product->redirectUrl))
            return redirect($this->convertRedirectUrlToApiVersion($product->redirectUrl), Response::HTTP_MOVED_PERMANENTLY, $request->headers->all());


        if ($product->grandParent != null)
            return redirect($product->grandParent->apiUrl['v1'], Response::HTTP_MOVED_PERMANENTLY, $request->headers->all());


        return response()->json($product);
    }

    private function convertRedirectUrlToApiVersion($url)
    {
        $url = parse_url($url);
        return url('/api/v1' . $url['path']);
    }
}
