<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 12/16/2018
 * Time: 12:00 PM
 */

namespace App\Classes\OrderProduct\RefinementProduct;

use App\Product;

class RefinementSimple extends RefinementAbstractClass
{
    private $product;

    public function __construct(Product $product, $data) {
        $this->product = $product;
    }

    public function getProducts() {
        $simpleProduct = collect();
        $simpleProduct->push($this->product);
        return $simpleProduct;
    }
}