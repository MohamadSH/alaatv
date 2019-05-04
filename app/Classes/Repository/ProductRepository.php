<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2019-04-21
 * Time: 18:07
 */

namespace App\Classes\Repository;

use App\Product;
use App\Traits\ProductCommon;

class ProductRepository
{
    use ProductCommon;

    /**
     * @param $fileName
     *
     * @return \App\Collection\ProductCollection
     */
    public static function getProductsThatHaveValidProductFileByFileNameRecursively(string $fileName)
    {
        $products = Product::whereIn('id', self::getArrayOfProductsIdThatHaveValidProductfileByFileName($fileName))
            ->OrwhereIn('id', self::getArrayOfProductsIdThatTheirParentHaveValidProductFileByFileName($fileName))
            ->OrwhereIn('id', self::getArrayOfProductsIdThatTheirComplimentaryHaveValidProductFileByFileName($fileName))
            ->OrwhereIn('id', self::getArrayOfProductsIdThatTheirGiftHaveValidProductFileByFileName($fileName))
            ->OrwhereIn('id',
                self::getArrayOfProductsIdThatTheirParentComplimentaryHaveValidProductFileByFileName($fileName))
            ->get();

        $totalProducts = collect();
        /** @var Product $product */
        foreach ($products as $product){
            $parents = $product->getAllParents();
            $totalProducts = $totalProducts->merge($parents);

            $children = $product->getAllChildren();
            $totalProducts = $totalProducts->merge($children);
        }
        $totalProducts = $totalProducts->merge($products);

        return $totalProducts;
    }
    
    /**
     * @param $fileName
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getArrayOfProductsIdThatHaveValidProductFileByFileName($fileName): \Illuminate\Support\Collection
    {
        return Product::whereHas('validProductfiles', function ($query) use ($fileName) {
            $query->where("file", $fileName);
        })
            ->get()
            ->pluck("id");
    }
    
    /**
     * @param $fileName
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getArrayOfProductsIdThatTheirParentHaveValidProductFileByFileName($fileName): \Illuminate\Support\Collection
    {
        return Product::whereHas('parents', function ($q) use ($fileName) {
            $q->whereHas('validProductfiles', function ($q) use ($fileName) {
                $q->where("file", $fileName);
            });
        })
            ->get()
            ->pluck("id");
    }
    
    /**
     * @param $fileName
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getArrayOfProductsIdThatTheirComplimentaryHaveValidProductFileByFileName($fileName): \Illuminate\Support\Collection
    {
        return Product::whereHas('complimentaryproducts', function ($q) use ($fileName) {
            $q->whereHas('validProductfiles', function ($q) use ($fileName) {
                $q->where("file", $fileName);
            });
        })
            ->get()
            ->pluck("id");
    }
    
    /**
     * @param $fileName
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getArrayOfProductsIdThatTheirGiftHaveValidProductFileByFileName($fileName): \Illuminate\Support\Collection
    {
        return Product::whereHas('gifts', function ($q) use ($fileName) {
            $q->whereHas('validProductfiles', function ($q) use ($fileName) {
                $q->where("file", $fileName);
            });
        })
            ->get()
            ->pluck("id");
    }
    
    /**
     * @param $fileName
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getArrayOfProductsIdThatTheirParentComplimentaryHaveValidProductFileByFileName($fileName): \Illuminate\Support\Collection
    {
        return Product::whereHas('parents', function ($q) use ($fileName) {
            $q->whereHas('complimentaryproducts', function ($q) use ($fileName) {
                $q->whereHas('validProductfiles', function ($q) use ($fileName) {
                    $q->where("file", $fileName);
                });
            });
        })
            ->get()
            ->pluck("id");
    }
}
