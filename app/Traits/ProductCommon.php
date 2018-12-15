<?php namespace App\Traits;

use App\Product;
use App\Productfiletype;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

trait ProductCommon
{
    /**
     * @param Product $product
     *
     * @return Collection
     */
    function makeAllFileCollection(Product $product): Collection
    {
        $key = "product:validProductfiles:pamphlet|video" . $product->cacheKey();

        return Cache::remember($key, config("constants.CACHE_60"), function () use ($product) {
            $productfiletypes = Productfiletype::all();
            $allFilesCollection = collect();
            foreach ($productfiletypes as $productfiletype) {
                $fileCollection = collect();
                $filesArray = $product->makeFileArray($productfiletype->name);
                if (!empty($filesArray))
                    $fileCollection->put($product->name, $filesArray);

                foreach ($product->children as $child) {
                    $filesArray = $child->makeFileArray($productfiletype->name);

                    if (!empty($filesArray))
                        $fileCollection->put($product->name, $filesArray);
                }

                if($fileCollection->isNotEmpty())
                    $allFilesCollection->push([
                                                  "typeName"        => $productfiletype->name,
                                                  "typeDisplayName" => $productfiletype->displayName,
                                                  "files"           => $fileCollection,
                                              ]);
            }
            return $allFilesCollection;
        });
    }

    /**
     * @param Product $product
     * @param         $chunk
     *
     * @return Collection
     */
    public function makeOtherProducts(Product $product, $chunk)
    {
        $exclusiveOtherProducts = Product::getExclusiveOtherProducts();

        $otherProducts = $product->getOtherProducts()->sortByDesc("created_at" );

        $totalOtherProducts = $this->mergeCollections($exclusiveOtherProducts, $otherProducts);

        $otherProductChunks = $totalOtherProducts->chunk($chunk);

        return $otherProductChunks;
    }

    /**
     * @param Product $product
     * @param         $extraAttributeValues
     *
     * @return int|float
     */
    public function productExtraCostFromAttributes(Product $product, $extraAttributeValues)
    {
        $key = "product:productExtraCostFromAttributes:Product"
            . "\\"
            . $product->cacheKey()
            . "\\extraAttributeValues:"
            . (isset($extraAttributeValues) ? implode("", $extraAttributeValues) : "-");
        return Cache::tags('bon')
                    ->remember($key, config("constants.CACHE_60"), function () use ($product, $extraAttributeValues) {
                        $totalExtraCost = 0;
                        foreach ($extraAttributeValues as $attributevalueId) {
                            $extraCost = 0;
                            $attributevalue = $product->attributevalues->where("id", $attributevalueId)
                                                                       ->first();

                            if (isset($attributevalue) && isset($attributevalue->pivot->extraCost))
                                $extraCost = $attributevalue->pivot->extraCost;

                            $totalExtraCost += $extraCost;
                        }
                        return $totalExtraCost;
                    });

    }

    /**
     * Finds product intended child based on specified attribute values
     *
     * @param Product $product
     * @param array   $mainAttributeValues
     *
     * @return Product
     */
    public function findProductChildViaAttributes(Product $product, array $mainAttributeValues): ?Product
    {
        foreach ($product->children as $child) {
            $childAttributevalues = $child->attributevalues;
            $flag = true;
            if (isset($mainAttributeValues))
                foreach ($mainAttributeValues as $attributevalue) {
                    if (!$childAttributevalues->contains($attributevalue)) {
                        $flag = false;
                        break;
                    }
                }

            if ($flag && $childAttributevalues->count() == count($mainAttributeValues)) {
                $simpleProduct = $child;
                break;
            }
        }
        return $simpleProduct;
    }

    protected function makeCostCollection($products)
    {
        $key = null;
        foreach ($products as $product)
            $key .= $product->cacheKey() . "-";
        $key = "product:makeCostCollection:" . md5($key);

        return Cache::remember($key, Config::get("constants.CACHE_60"), function () use ($products) {
            $costCollection = collect();
            foreach ($products as $product) {
                if ($product->producttype_id == 2) {
                    $enableChildren = $product->children->where("enable", 1);
                    if ($enableChildren->count() == 1) {
                        $costArray = $enableChildren->first()
                                                    ->calculatePayablePrice();
                    } else $costArray = $product->calculatePayablePrice();

                } else $costArray = $product->calculatePayablePrice();

                $costCollection->put($product->id, [
                    "cost"            => $costArray["cost"],
                    'productDiscount' => $costArray["productDiscount"],
                    'bonDiscount'     => $costArray['bonDiscount'],
                ]);
            }
            return $costCollection;

        });

    }

    protected function makeProductCollection($productsId = null)
    {
        $key = ":0-";
        if (isset($productsId)) {
            foreach ($productsId as $product)
                $key .= $product . "-";
        }
        $key = "product:makeProductCollection:" . $key;
        return Cache::remember($key, Config::get("constants.CACHE_60"), function () use ($productsId) {
            if (isset($productsId))
                $allProducts = Product::getProducts()
                                      ->whereIn("id", $productsId)
                                      ->orderBy("created_at", "Desc")
                                      ->get();
            else
                $allProducts = Product::getProducts()
                                      ->orderBy("created_at", "Desc")
                                      ->get();
            $products = collect();
            foreach ($allProducts as $product) {
                $products->push($product);
            }
            return $products;
        });
    }

    protected function haveSameFamily($products)
    {
        $key = null;
        foreach ($products as $product)
            $key .= $product->cacheKey() . "-";
        $key = "product:haveSameFamily:" . $key;
        return Cache::remember($key, Config::get("constants.CACHE_60"), function () use ($products) {
            $flag = true;
            foreach ($products as $key => $product) {
                if (isset($products[$key + 1])) {
                    if ($product->getGrandParent() !== false && $products[$key + 1]->getGrandParent() !== false) {
                        if ($product->getGrandParent()->id != $products[$key + 1]->getGrandParent()->id) {
                            $flag = false;
                            break;
                        }
                    } else {
                        $flag = false;
                        break;
                    }
                }
            }
            return $flag;
        });

    }

    protected function makeParentArray($myProduct)
    {
        $key = "product:makeParentArray:" . $myProduct->cacheKey();
        return Cache::remember($key, Config::get("constants.CACHE_60"), function () use ($myProduct) {
            $counter = 1;
            $parentsArray = [];
            while ($myProduct->hasParents()) {
                $parentsArray = array_add($parentsArray, $counter++, $myProduct->parents->first());
                $myProduct = $myProduct->parents->first();
            }
            return $parentsArray;
        });
    }

    /**
     * Copies a product files to another product
     *
     * @param Product $sourceProduct
     * @param Product $destinationProduct
     */
    public function copyProductFiles(Product $sourceProduct , Product $destinationProduct):void
    {
        $destinationProductFiles =  $sourceProduct->productfiles ;
        foreach ($destinationProductFiles as $file)
        {
            $newFile = $file->replicate();
            $newFile->product_id = $destinationProduct->id;
            $newFile->save();
        }
    }

    /**
     * @param Product $sourceProduct
     * @param Product $destinationProduct
     * @param array $newPhotoInfo
     */
    public function copyProductPhotos(Product $sourceProduct , Product $destinationProduct , array $newPhotoInfo=[]):void
    {
        $destinationProductPhotos =  $sourceProduct->photos ;
        foreach ($destinationProductPhotos as $photo)
        {
            $newPhoto = $photo->replicate();
            $newPhoto->product_id = $destinationProduct->id;
            $newPhoto->save();

            if(isset($newPhotoInfo["title"]))
            {
                $newPhoto->title = $newPhotoInfo["title"];
                $newPhoto->update();
            }
            if(isset($newPhotoInfo["description"]))
            {
                $newPhoto->description = $newPhotoInfo["description"];
                $newPhoto->update();
            }
        }
    }

}