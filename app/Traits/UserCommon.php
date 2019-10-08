<?php namespace App\Traits;

use App\Events\UserAvatarUploaded;
use App\User;
use App\Transaction;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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
    public function exchangeLottery($user, $points):array
    {
        /**   giving coupon */ /**do {
     * $couponCode = str_random(5);
     * }while(Coupon::where("code" , $couponCode)->get()->isNotEmpty());
     *
     * $insertCouponRequest = new \App\Http\Requests\InsertCouponRequest() ;
     * $insertCouponRequest->offsetSet("enable" , 1);
     * $insertCouponRequest->offsetSet("name" , "قرعه کشی همایش ویژه دی برای ".$user->getFullName());
     * $insertCouponRequest->offsetSet("code" , $couponCode);
     * $insertCouponRequest->offsetSet("discount" , config("constants.HAMAYESH_LOTTERY_EXCHANGE_AMOUNT"));
     * $insertCouponRequest->offsetSet("usageNumber" , 0);
     * $insertCouponRequest->offsetSet("usageLimit" , 1);
     * $insertCouponRequest->offsetSet("limitStatus" , 1);
     * $insertCouponRequest->offsetSet("coupontype_id" , 2);
     * $couponProducts = Product::whereNotIn("id" , [167,168,169,174,175,170,171,172,173,179,180,176,177,178])->get()->pluck('id')->toArray();
     * $insertCouponRequest->offsetSet("products" , $couponProducts);
     * $insertCouponRequest->offsetSet("validSince" , "2017-12-14T00:00:00");
     * $insertCouponRequest->offsetSet("validUntil" , "2017-12-19T24:00:00");
     * $result =  $couponController->store($insertCouponRequest)->status() == Response::HTTP_OK
     * if($result)
     * {
     * $attachCouponRequest = new \App\Http\Requests\SubmitCouponRequest() ;
     * $attachCouponRequest->offsetSet("coupon" , $couponCode);
     * $orderController = new \App\Http\Controllers\OrderController();
     * $orderController->submitCoupon($attachCouponRequest) ;
     * session()->forget('couponMessageError');
     * session()->forget('couponMessageSuccess');
     * $prizeName = "کد تخفیف ".$couponCode." با ".config("constants.HAMAYESH_LOTTERY_EXCHANGE_AMOUNT")."% تخفیف( تا تاریخ 1396/09/28 اعتبار دارد )" ;
     * }
     */

        /**   giving credit */
        $unitAmount    = config('constants.HAMAYESH_LOTTERY_EXCHANGE_AMOUNT');
        $amount        = $unitAmount * $points;
        $depositResult = $user->deposit($amount, config('constants.WALLET_TYPE_GIFT'));
        $done          = $depositResult['result'];
        $responseText  = $depositResult['responseText'];
        $objectId      = $depositResult['wallet'];
        $prizeName     = 'مبلغ '.number_format($amount).' تومان اعتبار هدیه';

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
    public function validateNationalCode($value):bool
    {
        $flag = false;
        if (!preg_match('/^[0-9]{10}$/', $value)) {
            $flag = false;
        }

        for ($i = 0; $i < 10; $i++) {
            if (preg_match('/^'.$i.'{10}$/', $value)) {
                $flag = false;
            }
        }

        for ($i = 0, $sum = 0; $i < 9; $i++) {
            $sum += ((10 - $i) * intval(substr($value, $i, 1)));
        }

        $ret    = $sum % 11;
        $parity = intval(substr($value, 9, 1));
        if (($ret < 2 && $ret == $parity) || ($ret >= 2 && $ret == 11 - $parity)) {
            $flag = true;
        }

        return $flag;
    }

    /**
     * @param $orders
     *
     * @return Transaction|Builder
     */
    public function getInstalments($orders): Builder
    {
        return Transaction::whereIn('order_id', $orders->pluck('id'))
            ->whereDoesntHave('parents')
            ->where('transactionstatus_id',
                config('constants.TRANSACTION_STATUS_UNPAID'));
    }

    /**
     * Returns validation rules for inserting a user
     *
     * @param  array  $data
     *
     * @return array
     */
    public function getInsertUserValidationRules(array $data): array
    {
        $rules = [
            'firstName'     => 'required|max:255',
            'lastName'      => 'required|max:255',
            'mobile'        => [
                'required',
                'digits:11',
                Rule::phone()
                    ->mobile()
                    ->country('AUTO,IR'),
                Rule::unique('users')
                    ->where(static function ($query) use ($data) {
                        $query->where('nationalCode', array_get($data, 'nationalCode'))
                            ->where('deleted_at', null);
                    }),
            ],
            'password'      => 'required|min:6',
            'nationalCode'  => [
                'required',
                'digits:10',
                'validate:nationalCode',
                Rule::unique('users')
                    ->where(static function ($query) use ($data) {
                        $query->where('mobile', array_get($data, 'mobile'))
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

    /**
     * @param User $user
     * @param        $file
     * @return string|null
     * @throws FileNotFoundException
     */
    protected function storePhotoOfUser(User $user, $file): ?string
    {
        $extension = $file->getClientOriginalExtension();
        $fileName  = basename($file->getClientOriginalName(), '.'.$extension).'_'.date('YmdHis').'.'.$extension;
        if (Storage::disk(config('constants.DISK24'))->put($fileName, File::get($file))) {
            $path = 'upload/images/profile/'.$fileName;
            event(new UserAvatarUploaded($user , $path));
            return $path;
        }

        return null;
    }

    /**
     * @param  array  $newRoleIds
     * @param  User   $staffUser
     * @param  User   $user
     */
    protected function syncRoles(array $newRoleIds, User $user): void
    {
        $oldRolesIds = $user->roles->pluck('id')
            ->toArray();
        if(!empty($oldRolesIds)) {
            $user->roles()->detach($oldRolesIds);
        }
        $user->roles()->attach($newRoleIds);
    }
}
