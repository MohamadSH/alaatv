<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2019-04-21
 * Time: 18:07
 */

namespace App\Classes\Repository;

use App\Collection\ProductCollection;
use App\Product;
use App\Traits\ProductCommon;
use Illuminate\Support\Collection;

class ProductRepository
{
    use ProductCommon;

    /**
     * @param $fileName
     *
     * @return ProductCollection
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

        return self::getTotalProducts($products);
    }

    /**
     * @param $fileName
     *
     * @return Collection
     */
    public static function getArrayOfProductsIdThatHaveValidProductFileByFileName($fileName): Collection
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
     * @return Collection
     */
    public static function getArrayOfProductsIdThatTheirParentHaveValidProductFileByFileName($fileName): Collection
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
     * @return Collection
     */
    public static function getArrayOfProductsIdThatTheirComplimentaryHaveValidProductFileByFileName($fileName): Collection
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
     * @return Collection
     */
    public static function getArrayOfProductsIdThatTheirGiftHaveValidProductFileByFileName($fileName): Collection
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
     * @return Collection
     */
    public static function getArrayOfProductsIdThatTheirParentComplimentaryHaveValidProductFileByFileName($fileName): Collection
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

    /**
     * @param Collection $products
     *
     * @return ProductCollection
     */
    private static function getTotalProducts(Collection $products)
    {
        $totalProducts = new ProductCollection();
        /** @var Product $product */
        foreach ($products as $product) {
            $productChain = $product->getProductChain();

            $totalProducts = $totalProducts->merge($productChain);
        }
        $totalProducts = $totalProducts->merge($products);

        return $totalProducts;
    }

}
