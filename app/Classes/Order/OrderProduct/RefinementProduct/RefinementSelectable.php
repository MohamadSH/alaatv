<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 12/16/2018
 * Time: 12:11 PM
 */

namespace App\Classes\Order\OrederProduct\RefinementProduct;

use App\Product;

class RefinementSelectable
{
    private $selectedProductsIds;
    private $product;

    public function __construct(Product $product, Request $request) {
        $this->selectedProductsIds = $request->get("products");
        $this->product = $product;
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

    public function getProducts():Product {
        $selectedProductsItems = Product::whereIn('id', $this->selectedProductsIds);

        if( count($this->selectedProductsIds) !== count($selectedProductsItems) ) {
            throw new Exception('produc ids not valid!');
        }

        foreach ($selectedProductsItems as $key => $productItem) {
            if (!$productItem->enable) {
                continue;
            }
            if ($productItem->hasParents()) {
                if (in_array($productItem->parents->first()->id, $this->selectedProductsIds)) {
                    $selectedProductsItems->forget($key);
                    $selectedProductsItems = $this->removeChildren($selectedProductsItems, $productItem);
                }
            }
        }

//        $RefinedSelectedProductsId = [];
//        foreach ($selectedProductsItems as $key => $productItem) {
//            $RefinedSelectedProductsId[] = $productItem->id;
//        }
//        return $RefinedSelectedProductsId;

        return $selectedProductsItems;
    }
}