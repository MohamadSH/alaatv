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
    public function hasContent(Content $content)
    {
        return $this->IsThereACommonProduct($content);
    }

    /**
     * @param Content $content
     *
     * @return bool
     */
    private function IsThereACommonProduct(Content $content): bool
    {
        return count(array_intersect($this->getUserProductsId(), $this->getContentProductsId($content))) > 0;
    }

    /**
     * @return array
     */
    private function getUserProductsId(): array
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
}
