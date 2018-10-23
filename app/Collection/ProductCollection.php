<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2018-10-11
 * Time: 15:57
 */

namespace App\Collection;

use App\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductCollection extends Collection
{
    /**
     * Removes products descendants from ProductCollection
     * Used in ProductCollection's keepOnlyParents method in order ro remove
     * a product's all descendants from a collection
     *
     * @param Product $product
     */
    public function removeProductDescendants(Product $product):void
    {
        $children = $product->children;
        $toArray = $this->pluck("id")->toArray();
        foreach ($children as $child)
        {
//          $ck = $this->search($child); // didn't work!!
            $key = array_search( $child->id , $toArray);
            if($key)
            {
                $this->forget($key);
                $grandChildren = $child->children;
                if($grandChildren->isNotEmpty())
                    $grandChildren->removeProductDescendants($child);
            }

        }
    }

    /**
     * If the collection contains parent of products , it keeps the parent and removes it's children
     * Used in ProductController@refreshPrice : In case of calculating the price for a selectable product
     * we need to keep only the parent product and remove all of it's children from the collection(which aren't necessary)
     *
     */
    public function keepOnlyParents():void
    {
        foreach ($this as $key => $simpleProduct)
        {
            $parent = $simpleProduct->parents->first();
            if (isset($parent) && $this->contains($parent))
            {
                $this->forget($key);
                $this->removeProductDescendants($simpleProduct);
            }
        }
    }
}