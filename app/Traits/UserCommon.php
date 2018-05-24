<?php namespace App\Traits;

trait UserCommon
{
    public function exchangeLottery($user , $points)
    {
        /**   giving coupon */
        /**do {
            $couponCode = str_random(5);
        }while(Coupon::where("code" , $couponCode)->get()->isNotEmpty());

        $insertCouponRequest = new \App\Http\Requests\InsertCouponRequest() ;
        $insertCouponRequest->offsetSet("enable" , 1);
        $insertCouponRequest->offsetSet("name" , "قرعه کشی همایش ویژه دی برای ".$user->getFullName());
        $insertCouponRequest->offsetSet("code" , $couponCode);
        $insertCouponRequest->offsetSet("discount" , Config::get("constants.HAMAYESH_LOTTERY_EXCHANGE_AMOUNT"));
        $insertCouponRequest->offsetSet("usageNumber" , 0);
        $insertCouponRequest->offsetSet("usageLimit" , 1);
        $insertCouponRequest->offsetSet("limitStatus" , 1);
        $insertCouponRequest->offsetSet("coupontype_id" , 2);
        $couponProducts = Product::whereNotIn("id" , [167,168,169,174,175,170,171,172,173,179,180,176,177,178])->get()->pluck('id')->toArray();
        $insertCouponRequest->offsetSet("products" , $couponProducts);
        $insertCouponRequest->offsetSet("validSince" , "2017-12-14T00:00:00");
        $insertCouponRequest->offsetSet("validUntil" , "2017-12-19T24:00:00");
        $result =  $couponController->store($insertCouponRequest)->status() == 200
         if($result)
         {
            $attachCouponRequest = new \App\Http\Requests\SubmitCouponRequest() ;
            $attachCouponRequest->offsetSet("coupon" , $couponCode);
            $orderController = new \App\Http\Controllers\OrderController();
            $orderController->submitCoupon($attachCouponRequest) ;
            session()->forget('couponMessageError');
            session()->forget('couponMessageSuccess');
           $prizeName = "کد تخفیف ".$couponCode." با ".Config::get("constants.HAMAYESH_LOTTERY_EXCHANGE_AMOUNT")."% تخفیف( تا تاریخ 1396/09/28 اعتبار دارد )" ;
         }
         */

        /**   giving credit */
        $unitAmount = config("constants.HAMAYESH_LOTTERY_EXCHANGE_AMOUNT") ;
        $amount = $unitAmount * $points ;
        $depositResult =  $user->deposit($amount , config("constants.WALLET_TYPE_GIFT"));
        $done = $depositResult["result"];
        $responseText = $depositResult["responseText"];
        $objectId = $depositResult["wallet"] ;
        $prizeName = "مبلغ ".number_format($amount)." تومان اعتبار هدیه";
        return [
            $done ,
            $responseText ,
            $prizeName ,
            $objectId
        ];
    }
}