<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 12/16/2018
 * Time: 12:11 PM
 */

namespace App\Classes\OrderProduct\RefinementProduct;

use App\Product;
use App\Attributevalue;
use Illuminate\Support\Collection;
use App\Collection\ProductCollection;
use Illuminate\Support\Facades\Log;

class RefinementConfigurable implements RefinementInterface
{
    private $attributes;
    private $product;

    public function __construct(Product $product, $data) {
        if(isset($data['attribute'])) {
            $this->attributes = $data["attribute"];
            $this->product = $product;
        } else {
            throw new Exception('attribute not set!');
        }
    }

    /**
     * @return ProductCollection|null
     */
    public function getProducts(): ?ProductCollection {
        $children = $this->product->children->load('attributevalues');
        $simpleProduct = new ProductCollection();
        foreach ($children as $child) {
            $childHasAllAttributes = $this->checkAttributesOfChild($this->attributes, $child);
            if($childHasAllAttributes) {
                $simpleProduct->push($child);
                break;
            }
        }
        return $simpleProduct;
    }

    private function checkAttributesOfChild($attributes, $child) {
        $flag = true;
        /** @var Attributevalue|Collection $attributesOfChild */
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