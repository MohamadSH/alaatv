<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2019-02-15
 * Time: 16:51
 */

namespace App\Traits\User;


use App\Content;
use App\Product;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

trait AssetTrait
{
    use FavoredTrait;

    public function products()
    {
        $result = DB::table('products')
                    ->join('orderproducts', function ($join) {
                        $join->on('products.id', '=', 'orderproducts.product_id')
                             ->whereNull('orderproducts.deleted_at');
                    })
                    ->join('orders', function ($join) {
                        $join->on('orders.id', '=', 'orderproducts.order_id')
                             ->whereIn('orders.orderstatus_id', [
                                 Config::get("constants.ORDER_STATUS_CLOSED"),
                                 Config::get("constants.ORDER_STATUS_POSTED"),
                                 Config::get("constants.ORDER_STATUS_READY_TO_POST"),
                             ])
                             ->whereNull('orders.deleted_at');
                    })
                    ->join('users', 'users.id', '=', 'orders.user_id')
                    ->select([

                        "products.*",
                    ])
                    ->where('users.id', '=', $this->getKey())
//                    ->orderBy("products.created_at")
                    ->whereNull('products.deleted_at')
                    ->distinct()
                    ->get();
        $result = Product::hydrate($result->toArray());

        return $result;
    }

    /**  Determines whether user has this content or not
     *
     * @param \App\Content $content
     *
     * @return bool
     */
    public function hasContent(Content $content)
    {
        return true;
    }

}