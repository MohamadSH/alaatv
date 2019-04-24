<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2019-04-21
 * Time: 18:07
 */

namespace App\Traits;


use App\Product;

trait ProductRepository
{
    /**
     * @param $fileName
     *
     * @return \App\Collection\ProductCollection
     */
    public static function getProductsThatHaveValidProductFileByFileNameRecursively($fileName)
    {
        $products = Product::whereIn('id', Product::getArrayOfProductsIdThatHaveValidProductfileByFileName($fileName))
                           ->OrwhereIn('id', Product::getArrayOfProductsIdThatTheirParentHaveValidProductFileByFileName($fileName))
                           ->OrwhereIn('id', Product::getArrayOfProductsIdThatTheirComplimentaryHaveValidProductFileByFileName($fileName))
                           ->OrwhereIn('id', Product::getArrayOfProductsIdThatTheirGiftHaveValidProductFileByFileName($fileName))
                           ->OrwhereIn('id', Product::getArrayOfProductsIdThatTheirParentComplimentaryHaveValidProductFileByFileName($fileName))
                           ->get();
        return $products;
    }

    /**
     * @param $fileName
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getArrayOfProductsIdThatHaveValidProductFileByFileName($fileName): \Illuminate\Support\Collection
    {
        return Product::whereHas('validProductfiles', function ($q) use ($fileName) {
            $q->where("file", $fileName);
        })->pluck("id");
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
        })->pluck("id");
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
        })->pluck("id");
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
        })->pluck("id");
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
        })->pluck("id");
    }
}