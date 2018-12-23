<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 12/16/2018
 * Time: 11:53 AM
 */

namespace App\Classes\OrderProduct\RefinementProduct;

use App\Product;
use Mockery\Exception;

class RefinementFactory
{
    public $RefinementClass;

    public function __construct($productId, $data=null) {
        $product = Product::FindorFail($productId);
        $typeName = $product->producttype->name;
        $className = 'App\Classes\OrderProduct\RefinementProduct\Refinement'.ucfirst($typeName);
        if(class_exists($className)) {
            $RefinementClass = new $className($product, $data);
            $this->RefinementClass = $RefinementClass;
        } else if($typeName=='configurable') {
            throw new Exception('Type Name {'.$typeName.'} not found.');
        }
    }

    public function getRefinementClass() {
        return $this->RefinementClass;
    }
}