<?php


namespace App\Repositories;


use App\Orderproduct;
use Illuminate\Database\Eloquent\Builder;

class OrderproductRepo
{
    const NOT_CHECKEDOUT_ORDERPRODUCT = 'unchecked';
    const CHECKEDOUT_ORDERPRODUCT = 'checked';
    const CHECKOUT_ALL = 'all';

    public static function refreshOrderproductTmpPrice(Orderproduct $orderproduct, int $tmpFinal, int $tmpExtraCost): bool
    {
        return $orderproduct->update([
            'tmp_final_cost' => $tmpFinal,
            'tmp_extra_cost' => $tmpExtraCost,
        ]);
    }

    public static function refreshOrderproductTmpShare(Orderproduct $orderproduct, $share): bool
    {
        return $orderproduct->update([
            'tmp_share_order' => $share,
        ]);
    }

    public static function getPurchasedOrderproducts(array $productIds = [], string $since = null, string $till = null, string $checkoutMode = 'all'): Builder
    {
        $orderproducts = Orderproduct::where('orderproducttype_id', config('constants.ORDER_PRODUCT_TYPE_DEFAULT'))
            ->whereHas('order', function ($q) use ($since, $till) {
                $q->whereIn('orderstatus_id', [config('constants.ORDER_STATUS_CLOSED'), config('constants.ORDER_STATUS_POSTED')])
                    ->whereIn('paymentstatus_id', [config('constants.PAYMENT_STATUS_PAID'), config('constants.PAYMENT_STATUS_VERIFIED_INDEBTED')]);

                if (isset($since))
                    $q->where('completed_at', '>=', $since);

                if (isset($till))
                    $q->where('completed_at', '<=', $till);
            });

        if (!empty($productIds))
            $orderproducts->whereIn('product_id', $productIds);

        if ($checkoutMode == 'checked') {
            $orderproducts->where('checkoutstatus_id', config('constants.ORDERPRODUCT_CHECKOUT_STATUS_PAID'));
        } else if ($checkoutMode == 'unchecked') {
            $orderproducts->where(function ($q2) {
                $q2->where('checkoutstatus_id', config('constants.ORDERPRODUCT_CHECKOUT_STATUS_UNPAID'))
                    ->orWhereNull('checkoutstatus_id');
            });
        }

        return $orderproducts;
    }

    public static function createGiftOrderproduct(int $orderId, int $giftId, $giftCost): Orderproduct
    {
        return Orderproduct::create([
            'orderproducttype_id' => config("constants.ORDER_PRODUCT_GIFT"),
            'order_id'            => $orderId,
            'product_id'          => $giftId,
            'cost'                => $giftCost,
            'discountPercentage'  => 100,
        ]);
    }

    public static function createBasicOrderproduct(int $orderId, int $productId, $finalPrice, $tempFinalPrice = null): Orderproduct
    {
        return Orderproduct::Create([
            'order_id'            => $orderId,
            'product_id'          => $productId,
            'cost'                => $finalPrice,
            'tmp_final_cost'      => $tempFinalPrice,
            'orderproducttype_id' => config('constants.ORDER_PRODUCT_TYPE_DEFAULT'),
        ]);
    }
}
