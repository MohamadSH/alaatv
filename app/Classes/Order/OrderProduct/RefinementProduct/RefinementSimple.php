<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 12/16/2018
 * Time: 12:00 PM
 */

namespace App\Classes\Order\OrederProduct\RefinementProduct;

use App\Product;

class RefinementSimple
{
    private $request;
    private $product;

    public function __construct(Product $product, Request $request) {

        $this->request = $request;
        $this->product = $product;
//
//        $simpleProduct = $product;
//        return $simpleProduct;

//        $product = Product::FindorFail($inputs);
//        $simpleProduct = Product::getProductsByIDs($inputs[0])->scopeSimple();
//        if(count($simpleProduct)==1) {
//            return $simpleProduct;
//        } else {
//            throw new Exception('expect one product id for simple product.');
//        }
    }

    public function getProducts():Product {

        $simpleProduct = collect();
        $simpleProduct->push($this->product);
        return $simpleProduct;
    }
}