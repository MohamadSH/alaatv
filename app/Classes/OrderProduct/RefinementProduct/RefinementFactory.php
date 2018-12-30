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
    private $RefinementClass;
    private $productId;
    private $data;

    public function __construct($productId, $data=null) {
        $this->productId = $productId;
        $this->data = $data;
    }

    public function getRefinementClass() {
        $product = Product::FindorFail($this->productId);
        $typeName = $product->producttype->name;
        $className = __NAMESPACE__.'\Refinement'.ucfirst($typeName);
        if(class_exists($className)) {
            $RefinementClass = new $className($product, $this->data);
            $this->RefinementClass = $RefinementClass;
        } else {
            throw new Exception('Type Name {'.$typeName.'} not found.');
        }
        return $this->RefinementClass;
    }
}