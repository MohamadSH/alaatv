<?php namespace App\Traits;

use App\Http\Requests\Request;
use App\Product;
use Illuminate\Config\Repository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

trait ProductCommon
{
    /**
     * @param Product   $product
     * @param           $extraAttributeValues
     *
     * @return int|float
     */
    public function productExtraCostFromAttributes(Product $product, $extraAttributeValues)
    {
        $key =
            'product:productExtraCostFromAttributes:' . "\\" . $product->cacheKey() . "\\extraAttributeValues:" . (isset($extraAttributeValues) ? implode('',
                $extraAttributeValues) : '-');

        return (int)Cache::tags(['product', 'product_' . $product->id])
            ->remember($key, config('constants.CACHE_60'), function () use ($product, $extraAttributeValues) {
                $totalExtraCost = 0;
                foreach ($extraAttributeValues as $attributevalueId) {
                    $extraCost      = 0;
                    $attributevalue = $product->attributevalues->where('id', $attributevalueId)
                        ->first();

                    if (isset($attributevalue) && isset($attributevalue->pivot->extraCost)) {
                        $extraCost = $attributevalue->pivot->extraCost;
                    }

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
            $flag                 = true;
            if (isset($mainAttributeValues)) {
                foreach ($mainAttributeValues as $attributevalue) {
                    if (!$childAttributevalues->contains($attributevalue)) {
                        $flag = false;
                        break;
                    }
                }
            }

            if ($flag && $childAttributevalues->count() == count($mainAttributeValues)) {
                $simpleProduct = $child;
                break;
            }
        }
        if (isset($simpleProduct)) {
            return $simpleProduct;
        } else {
            return null;
        }
    }

    /**
     * Copies a product files to another product
     *
     * @param Product $sourceProduct
     * @param Product $destinationProduct
     */
    public function copyProductFiles(Product $sourceProduct, Product $destinationProduct): void
    {
        $destinationProductFiles = $sourceProduct->productfiles;
        foreach ($destinationProductFiles as $file) {
            $newFile             = $file->replicate();
            $newFile->product_id = $destinationProduct->id;
            $newFile->save();
        }
    }

    /**
     * @param Product $sourceProduct
     * @param Product $destinationProduct
     * @param array   $newPhotoInfo
     */
    public function copyProductPhotos(Product $sourceProduct, Product $destinationProduct, array $newPhotoInfo = []): void
    {
        $destinationProductPhotos = $sourceProduct->photos;
        foreach ($destinationProductPhotos as $photo) {
            $newPhoto             = $photo->replicate();
            $newPhoto->product_id = $destinationProduct->id;
            $newPhoto->save();

            if (isset($newPhotoInfo['title'])) {
                $newPhoto->title = $newPhotoInfo['title'];
                $newPhoto->update();
            }
            if (isset($newPhotoInfo['description'])) {
                $newPhoto->description = $newPhotoInfo['description'];
                $newPhoto->update();
            }
        }
    }

    /**
     * Calculates costs of a product collection
     *
     * @param Collection $products
     *
     * @return mixed
     */
    protected function makeCostCollection(Collection $products)
    {
        $key       = null;
        $cacheTags = ['product'];
        foreach ($products as $product) {
            $key         .= $product->cacheKey() . '-';
            $cacheTags[] = 'product_' . $product->id;
        }
        $key = 'product:makeCostCollection:' . md5($key);

        return Cache::tags($cacheTags)
            ->remember($key, config('constants.CACHE_60'), function () use ($products) {
                $costCollection = collect();
                foreach ($products as $product) {
                    if ($product->producttype_id == config('constants.PRODUCT_TYPE_CONFIGURABLE')) {
                        /** @var Collection $enableChildren */
                        $enableChildren = $product->children->where('enable',
                            1); // It is not query efficient to use scopeEnable
                        if ($enableChildren->count() == 1) {
                            $costArray = $enableChildren->first()
                                ->calculatePayablePrice();
                        } else {
                            $costArray = $product->calculatePayablePrice();
                        }
                    } else if ($product->producttype_id == config('constants.PRODUCT_TYPE_SELECTABLE')) {
                        $allChildren                  = $product->getAllChildren()
                            ->where('pivot.isDefault', 1);
                        $costArray                    = [];
                        $costArray['productDiscount'] = null;
                        $costArray['bonDiscount']     = null;
                        $costArray['costForCustomer'] = 0;
                        $costArray['cost']            = 0;
                        if (is_callable([$this, 'refreshPrice'])) {
                            $request = new Request();
                            $request->offsetSet('products', $allChildren->pluck('id')
                                ->toArray());
                            $request->offsetSet('type', 'productSelection');
                            $costInfo                     = $this->refreshPrice($request, $product);
                            $costInfo                     = json_decode($costInfo);
                            $costArray['costForCustomer'] = $costInfo->costForCustomer;
                            $costArray['cost']            = $costInfo->cost;
                        }
//                    $costArray = $product->calculatePayablePrice();
                    } else {
                        $costArray = $product->calculatePayablePrice();
                    }

                    $costCollection->put($product->id, [
                        'cost'            => $costArray['cost'],
                        'productDiscount' => $costArray['productDiscount'],
                        'bonDiscount'     => $costArray['bonDiscount'],
                        'costForCustomer' => isset($costArray['costForCustomer']) ? $costArray['costForCustomer'] : 0,
                    ]);
                }

                return $costCollection;
            });
    }

    protected function makeProductCollection($productsId = null)
    {
        $key       = '';
        $cacheTags = ['product', 'productCollection'];
        if (isset($productsId)) {
            foreach ($productsId as $product) {
                $cacheTags[] = 'product_' . $product;
                $key         .= $product . '-';
            }
        }
        $key = 'product:makeProductCollection:' . $key;

        return Cache::tags($cacheTags)
            ->remember($key, config('constants.CACHE_60'), function () use ($productsId) {
                if (!isset($productsId)) {
                    $productsId = [];
                }

                $allProducts = Product::getProducts(0, 0, [], 'created_at', 'desc', $productsId)->get();

                $products = collect();
                foreach ($allProducts as $product) {
                    $products->push($product);
                }

                return $products;
            });
    }

    protected function haveSameFamily($products)
    {
        $key       = null;
        $cacheTags = ['product'];
        foreach ($products as $product) {
            $key         .= $product->cacheKey() . '-';
            $cacheTags[] = 'product_' . $product->id;
        }
        $key = 'product:haveSameFamily:' . $key;

        return Cache::tags($cacheTags)
            ->remember($key, config('constants.CACHE_60'), function () use ($products) {
                $flag = true;
                foreach ($products as $key => $product) {
                    if (isset($products[$key + 1])) {
                        if ($product->grandParent != null && $products[$key + 1]->grandParent != null) {
                            if ($product->grandParent->id != $products[$key + 1]->grandParent->id) {
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

    /**
     * @param Repository $videoDisk
     * @param                               $videoUrl
     * @param                               $videoPath
     * @param                               $size
     * @param string                        $caption
     * @param string                        $res
     * @param                               $videoExtension
     *
     * @return array
     */
    protected function makeIntroVideoFileStdClass(string $videoDisk, string $videoUrl, string $videoPath, string $videoExtension = null, $size = null, string $caption = null, string $res = null): array
    {
        $hqVideo = [
            'uuid'     => Str::uuid()->toString(),
            'disk'     => $videoDisk,
            'url'      => $videoUrl,
            'fileName' => $videoPath,
            'size'     => $size,
            'caption'  => $caption,
            'res'      => $res,
            'type'     => 'video',
            'ext'      => $videoExtension,
        ];
        return $hqVideo;
    }

    /**
     * @param Repository $thumbnailDisk
     * @param                               $thumbnailUrl
     * @param                               $thumbnailPath
     * @param                               $size
     * @param                               $caption
     * @param                               $res
     * @param                               $thumbnailExtension
     *
     * @return array
     */
    protected function makeVideoFileThumbnailStdClass(string $thumbnailDisk, string $thumbnailUrl, string $thumbnailPath, string $thumbnailExtension = null, $size = null, $caption = null, string $res = null): array
    {
        $thumbnail = [
            'uuid'     => Str::uuid()->toString(),
            'disk'     => $thumbnailDisk,
            'url'      => $thumbnailUrl,
            'fileName' => $thumbnailPath,
            'size'     => $size,
            'caption'  => $caption,
            'res'      => $res,
            'type'     => 'thumbnail',
            'ext'      => $thumbnailExtension,
        ];
        return $thumbnail;
    }

    /**
     * @param array $hqVideo
     *
     * @return array
     */
    protected function mekeIntroVideosArray(array $hqVideo): array
    {
        $video = [
            $hqVideo,
        ];
        return $video;
    }

}
