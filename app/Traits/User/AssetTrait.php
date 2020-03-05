<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2019-02-15
 * Time: 16:51
 */

namespace App\Traits\User;

use App\Collection\ProductCollection;
use App\Content;
use App\Product;
use App\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

trait AssetTrait
{
    use FavoredTrait;

    /**  Determines whether user has this content or not
     *
     * @param Content $content
     *
     * @return bool
     */
    public function hasContent(Content $content):bool
    {
        return count(array_intersect($this->getUserProductsId(), $this->getContentProductsId($content))) > 0;
    }

    /**
     * @return array
     */
    public function getUserProductsId(): array
    {
        return $this->products()
                   ->pluck('id')
                   ->toArray();
    }

    /**
     * @return ProductCollection
     */
    public function products(): ProductCollection
    {
        $key = 'userProducts:'.$this->cacheKey() ;
        return Cache::tags(['userAsset' , 'userAsset_'.$this->id])
            ->remember($key, config('constants.CACHE_60'), function () {
                $result = DB::table('products')
                    ->join('orderproducts', function ($join) {
                        $join->on('products.id', '=', 'orderproducts.product_id')
                            ->whereNull('orderproducts.deleted_at');
                    })
                    ->join('orders', function ($join) {
                        $join->on('orders.id', '=', 'orderproducts.order_id')
                            ->whereIn('orders.orderstatus_id', [
                                config("constants.ORDER_STATUS_CLOSED"),
                                config("constants.ORDER_STATUS_POSTED"),
                                config("constants.ORDER_STATUS_READY_TO_POST"),
                            ])
                            ->whereIn('orders.paymentstatus_id', [
                                config("constants.PAYMENT_STATUS_PAID"),
                                config("constants.PAYMENT_STATUS_VERIFIED_INDEBTED"),
                                config("constants.PAYMENT_STATUS_ORGANIZATIONAL_PAID"),
                            ])
                            ->whereNull('orders.deleted_at');
                    })
                    ->join('users', 'users.id', '=', 'orders.user_id')
                    ->select([
                        'products.*', 'orders.completed_at',
                    ])
                    ->where('users.id', '=', $this->getKey())
                    ->whereNotIn('products.id', [Product::DONATE_PRODUCT_5_HEZAR, Product::CUSTOM_DONATE_PRODUCT, Product::ASIATECH_PRODUCT])
                    ->whereNull('products.deleted_at')
                    ->distinct()
                    ->get();

                return Product::hydrate($result->toArray());
            });
    }

    /**
     * @param Content $content
     *
     * @return array
     */
    private function getContentProductsId(Content $content): array
    {
        return $content->allProducts()
            ->pluck('id')
            ->toArray();
    }

    private function searchProductInUserAssetsCollection(Product $product, ?User $user):bool
    {
        if(is_null($user)){
            return false;
        }

        $key = 'searchProductInUserAssetsCollection:' . $product->cacheKey().'-'.$user->cacheKey();
        return Cache::tags(['searchInUserAsset' , 'searchInUserAsset_'.$user->id , 'userAsset' , 'userAsset_'.$user->id])
            ->remember($key, config('constants.CACHE_60'), function () use ($user , $product) {

                $userAssetsArray    = $user->getUserProductsId() ;
                if(empty($userAssetsArray)){
                    return false ;
                }

                return in_array($product->id, $userAssetsArray);
            });
    }

    private function searchProductTreeInUserAssetsCollection(Product $product, ?User $user):array
    {
        $purchasedProductIdArray = [];

        if(is_null($user)){
            return $purchasedProductIdArray;
        }

        $key = 'searchProductTreeInUserAssetsCollection:' . $product->cacheKey().'-'.$user->cacheKey();
        return Cache::tags(['searchInUserAsset' , 'searchInUserAsset_'.$user->id , 'userAsset' , 'userAsset_'.$user->id])
            ->remember($key, config('constants.CACHE_60'), function () use ($user , $product , $purchasedProductIdArray) {

                $userAssetsArray    = $user->getUserProductsId() ;
                if(empty($userAssetsArray)){
                    return $userAssetsArray ;
                }

                $this->iterateProductAndChildrenInAsset($userAssetsArray, $product, $purchasedProductIdArray);

                return $purchasedProductIdArray;
            });
    }

    private function iterateProductAndChildrenInAsset(array $userAssetsArray, Product $product, array & $purchasedProductIdArray):void
    {
        if (in_array($product->id, $userAssetsArray)) {
            $purchasedProductIdArray[] = $product->id;
            $purchasedProductIdArray = array_merge($purchasedProductIdArray , $product->getAllChildren()->pluck('id')->toArray());
        }else{
            $grandChildren = $product->getAllChildren(); ;
            $hasBoughtEveryChild = $grandChildren->isEmpty()?false:true;
            foreach ($grandChildren as $grandChild) {
                if(!in_array($grandChild->id, $userAssetsArray)){
                    $hasBoughtEveryChild = false;
                    break;
                }
            }

            if($hasBoughtEveryChild){
                $purchasedProductIdArray[] = $product->id ;
            }
        }



        $children = $product->children;
        if ($children->count() > 0) {
            foreach ($children as $key=>$childProduct) {
                $this->iterateProductAndChildrenInAsset($userAssetsArray, $childProduct, $purchasedProductIdArray);
            }
        }
    }
}
