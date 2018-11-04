<?php namespace App\Traits;


use App\Http\Controllers\UserController;
use function GuzzleHttp\Promise\all;

trait UserCommon
{
    /**
     * Exchange user lottery points
     *
     * @param $user
     * @param $points
     *
     * @return array
     */
    public function exchangeLottery($user, $points)
    {
        /**   giving coupon */
        /**do {
         * $couponCode = str_random(5);
         * }while(Coupon::where("code" , $couponCode)->get()->isNotEmpty());
         *
         * $insertCouponRequest = new \App\Http\Requests\InsertCouponRequest() ;
         * $insertCouponRequest->offsetSet("enable" , 1);
         * $insertCouponRequest->offsetSet("name" , "قرعه کشی همایش ویژه دی برای ".$user->getFullName());
         * $insertCouponRequest->offsetSet("code" , $couponCode);
         * $insertCouponRequest->offsetSet("discount" , Config::get("constants.HAMAYESH_LOTTERY_EXCHANGE_AMOUNT"));
         * $insertCouponRequest->offsetSet("usageNumber" , 0);
         * $insertCouponRequest->offsetSet("usageLimit" , 1);
         * $insertCouponRequest->offsetSet("limitStatus" , 1);
         * $insertCouponRequest->offsetSet("coupontype_id" , 2);
         * $couponProducts = Product::whereNotIn("id" , [167,168,169,174,175,170,171,172,173,179,180,176,177,178])->get()->pluck('id')->toArray();
         * $insertCouponRequest->offsetSet("products" , $couponProducts);
         * $insertCouponRequest->offsetSet("validSince" , "2017-12-14T00:00:00");
         * $insertCouponRequest->offsetSet("validUntil" , "2017-12-19T24:00:00");
         * $result =  $couponController->store($insertCouponRequest)->status() == 200
         * if($result)
         * {
         * $attachCouponRequest = new \App\Http\Requests\SubmitCouponRequest() ;
         * $attachCouponRequest->offsetSet("coupon" , $couponCode);
         * $orderController = new \App\Http\Controllers\OrderController();
         * $orderController->submitCoupon($attachCouponRequest) ;
         * session()->forget('couponMessageError');
         * session()->forget('couponMessageSuccess');
         * $prizeName = "کد تخفیف ".$couponCode." با ".Config::get("constants.HAMAYESH_LOTTERY_EXCHANGE_AMOUNT")."% تخفیف( تا تاریخ 1396/09/28 اعتبار دارد )" ;
         * }
         */

        /**   giving credit */
        $unitAmount = config("constants.HAMAYESH_LOTTERY_EXCHANGE_AMOUNT");
        $amount = $unitAmount * $points;
        $depositResult = $user->deposit($amount, config("constants.WALLET_TYPE_GIFT"));
        $done = $depositResult["result"];
        $responseText = $depositResult["responseText"];
        $objectId = $depositResult["wallet"];
        $prizeName = "مبلغ " . number_format($amount) . " تومان اعتبار هدیه";
        return [
            $done,
            $responseText,
            $prizeName,
            $objectId,
        ];
    }

    /**
     * Validates national code
     *
     * @param $value
     *
     * @return bool
     */
    public function validateNationalCode($value)
    {
        $flag = false;
        if (!preg_match('/^[0-9]{10}$/', $value))
            $flag = false;

        for ($i = 0; $i < 10; $i++)
            if (preg_match('/^' . $i . '{10}$/', $value))
                $flag = false;

        for ($i = 0, $sum = 0; $i < 9; $i++)
            $sum += ((10 - $i) * intval(substr($value, $i, 1)));

        $ret = $sum % 11;
        $parity = intval(substr($value, 9, 1));
        if (($ret < 2 && $ret == $parity) || ($ret >= 2 && $ret == 11 - $parity))
            $flag = true;

        return $flag;
    }

    /**
     * Checks whether user has default avatar or not
     *
     * @param $photo
     *
     * @return bool
     */
    public function userHasDefaultAvatar($photo): bool
    {
        return strcmp($photo, config('constants.PROFILE_DEFAULT_IMAGE')) != 0;
    }

    /**
     * Determines oldPassword and newPassword confirmation of the user
     *
     * @param \App\User $user
     * @param string    $claimedOldPassword
     * @param string    $newPassword
     *
     * @return array
     */
    public function userPasswordConfirmation(\App\User $user, $claimedOldPassword, $newPassword): array
    {
        $confirmed = false;
        if ($user->compareWithCurrentPassword($claimedOldPassword)) {
            if (!$user->compareWithCurrentPassword($newPassword)) {
                $confirmed = true;
                $message = \Lang::get('confirmation.Confirmed.');
            } else {
                $message = \Lang::get('confirmation.Current password and new password are the same.');
            }
        } else {
            $message = \Lang::get('confirmation.Claimed old password is not correct');
        }

        return [
            "confirmed" => $confirmed,
            "message"   => $message,
        ];
    }

    /**
     *  Determines whether user's profile is locked or not
     *
     * @param \App\User $user
     *
     * @return bool
     */
    public function isUserProfileLocked(\App\User $user): bool
    {
        return $user->lockProfile == 1;
    }

    /**
     * @param $orders
     *
     * @return \App\Transaction|\Illuminate\Database\Eloquent\Builder
     */
    public function getInstalments($orders): \Illuminate\Database\Eloquent\Builder
    {
        return \App\Transaction::whereIn("order_id", $orders->pluck("id"))
                               ->whereDoesntHave("parents")
                               ->where("transactionstatus_id", config("constants.TRANSACTION_STATUS_UNPAID"));
    }

    public function callUserControllerStore($data)
    {
        $storeUserRequest = new \App\Http\Requests\InsertUserRequest();
        $storeUserRequest->merge($data);
        $storeUserRequest->headers->add(["X-Requested-With" => "XMLHttpRequest"]);
        $userController = new UserController(new \Jenssegers\Agent\Agent(), new \App\Websitesetting());
        $response = $userController->store($storeUserRequest);
        return $response;
    }

    public function getInsertUserValidationRules()
    {
        $rules = [
            'firstName'     => 'required|max:255',
            'lastName'      => 'required|max:255',
            'mobile'        => [
                'required',
                'digits:11',
                'phone:AUTO,IR,mobile',
                \Illuminate\Validation\Rule::unique('users')
                    ->where(function ($query) {
                        $query->where('nationalCode', $_REQUEST["nationalCode"])
                            ->where('deleted_at', null);
                    }),
            ],
            'password'      => 'required|min:6',
            'nationalCode'  => [
                'required',
                'digits:10',
                'validate:nationalCode',
                \Illuminate\Validation\Rule::unique('users')
                    ->where(function ($query) {
                        $query->where('mobile', $_REQUEST["mobile"])
                            ->where('deleted_at', null);
                    }),
            ],
            'userstatus_id' => 'required|exists:userstatuses,id',
            'photo'         => 'image|mimes:jpeg,jpg,png|max:512',
            'postalCode'    => 'sometimes|nullable|numeric',
            'major_id'      => 'sometimes|nullable|exists:majors,id',
            'gender_id'     => 'sometimes|nullable|exists:genders,id',
            'email'         => 'sometimes|nullable|email',
        ];

        return $rules;
    }
}