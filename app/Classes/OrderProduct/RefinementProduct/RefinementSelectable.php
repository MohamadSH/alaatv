<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 12/16/2018
 * Time: 12:11 PM
 */

namespace App\Classes\OrderProduct\RefinementProduct;

use App\Product;
use Exception;

class RefinementSelectable implements RefinementInterface
{
    private $selectedProductsIds;
    private $product;

    public function __construct(Product $product, $data) {
        if(isset($data['products'])) {
            $this->selectedProductsIds = $data["products"];
            $this->product = $product;
        } else {
            throw new Exception('products not set!');
        }
    }

    public function getProducts() {
        $selectedProductsItems = Product::whereIn('id', $this->selectedProductsIds)->enable()->get();

        $selectedProductsItems->keepOnlyParents();

        return $selectedProductsItems;
    }

    private function removeChildren($selectedProductsItems, Product $productItem) {
        $childrenArray = $productItem->children;
        foreach ($childrenArray as $child) {
            foreach ($selectedProductsItems as $key=>$item) {
                if($item->id==$child->id) {
                    $selectedProductsItems->forget($key);
                    $selectedProductsItems = $this->removeChildren($selectedProductsItems, $child);
                }
            }
        }
        return $selectedProductsItems;
    }
}