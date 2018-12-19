<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 12/16/2018
 * Time: 12:11 PM
 */

namespace App\Classes\Order\OrderProduct\RefinementProduct;

use App\Product;

class RefinementConfigurable
{
    private $attributes;
    private $product;

    public function __construct(Product $product, $data) {
        $this->attributes = $data["attribute"];
        $this->product = $product;
    }

    public function getProducts() {
        $childrens = $this->product->children;
        foreach ($childrens as $child) {
            $childHaveAllAttributes = $this->checkAttributesOfChild($this->attributes, $child);
            if($childHaveAllAttributes) {
                $simpleProduct = collect();
                $simpleProduct->push($child);
                return $simpleProduct;
            }
        }
    }

    private function checkAttributesOfChild($attributes, $child) {
        $flag = true;
        $attributesOfChild = $child->attributevalues;
        foreach ($attributes as $attribute) {
            if (!$attributesOfChild->contains($attribute)) {
                $flag = false;
                break;
            }
        }
        if ($flag && $attributesOfChild->count() == count($this->attributes)) {
            return $child;
        } else {
            return false;
        }
    }
}