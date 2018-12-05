<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 12/5/2018
 * Time: 4:12 PM
 */

namespace App\Classes\Checkout\Alaa\Chains;


use App\Classes\Abstracts\Checkout\OrderproductCouponChecker;
use App\Coupon;
use Illuminate\Support\Collection;

class AlaaOrderproductCouponChecker extends OrderproductCouponChecker
{
    protected function IsIncludedInCoupon(Collection $orderproducts , Coupon $coupon) :Collection
    {
        foreach ($orderproducts as $orderproduct)
        {
            if (!isset($coupon->coupontype->id) || $coupon->coupontype->id == config("constants.COUPON_TYPE_OVERALL")) {
                $orderproduct->includedInCoupon = 1;
            } else {
                $flag = true;
                if (!in_array($coupon->id, $orderproduct->product->coupons->pluck('id')
                    ->toArray())) {
                    $flag = false;
                    $parentsArray = $this->makeParentArray($orderproduct->product);
                    foreach ($parentsArray as $parent) {
                        if (in_array($coupon->id, $parent->coupons->pluck('id')
                            ->toArray())) {
                            $flag = true;
                            break;
                        }
                    }
                }
                if ($flag) {
                    $orderproduct->includedInCoupon = 1;
                } else {
                    $orderproduct->includedInCoupon = 0;
                }
            }

            $orderproduct->update();
        }

        return $orderproducts ;
    }

}