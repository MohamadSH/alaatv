<?php

namespace App;

use App\Traits\Helper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Coupon
 *
 * @property int $id
 * @property int|null $coupontype_id آی دی مشخص کننده نوع کپن
 * @property int|null $discounttype_id نوع تخفیف
 * @property string|null $name نام کپن
 * @property int $enable فعال یا غیرفعال بودن کپن برای استفاده جدید
 * @property string|null $description توضیحات کپن
 * @property string|null $code کد کپن
 * @property float $discount میزان تخفیف کپن به درصد
 * @property int|null $maxCost بیشسینه قیمت مورد نیاز برای استفاده از این کپن
 * @property int|null $usageLimit حداکثر تعداد مجاز تعداد استفاده از کپن - اگر نال باشد یعنی نامحدود
 * @property int $usageNumber تعداد استفاده ها از کپن تا این لحظه
 * @property string|null $validSince تاریخ شروع معتبر بودن کپن
 * @property string|null $validUntil تاریخ پایان معتبر بودن کپن
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \App\Coupontype|null $coupontype
 * @property-read \App\Discounttype|null $discounttype
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $marketers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Order[] $orders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Product[] $products
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Coupon onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereCoupontypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereDiscounttypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereMaxCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereUsageLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereUsageNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereValidSince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereValidUntil($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Coupon withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Coupon withoutTrashed()
 * @mixin \Eloquent
 */
class Coupon extends Model
{
    use SoftDeletes;
    use Helper;
    /**      * The attributes that should be mutated to dates.        */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'enable',
        'description',
        'code',
        'discount',
        'maxCost',
        'usageLimit',
        'usageNumber',
        'validSince',
        'validUntil',
        'coupontype_id',
        'discounttype_id'
    ];

    public function marketers()
    {
        return $this->belongsToMany('App\User');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Order');
    }

    public function coupontype()
    {
        return $this->belongsTo('App\Coupontype');
    }

    public function products()
    {
        return $this->belongsToMany('App\Product');
    }

    public function discounttype()
    {
        return $this->belongsTo("\App\Discounttype");
    }

    /**
     * Validates a coupon
     *
     * @return array
     */
    public function validateCoupon()
    {
        $message = "" ;
        $validationCode = 0;
        if (!$this->enable)
        {
            $message =  "کپن وارد شده غیر فعال می باشد";
            $validationCode = 1;
        }
        elseif (isset($this->validSince) && Carbon::now() < $this->validSince)
        {
            $message =  "تاریخ استفاده از کپن آغاز نشده است";
            $validationCode = 2;
        }
        elseif (isset($this->validUntil) && Carbon::now() > $this->validUntil)
        {
            $message =  "تاریخ استفاده از کپن به پایان رسیده است";
            $validationCode = 3;
        }
        elseif (isset($this->usageLimit) && $this->usageNumber >= $this->usageLimit)
        {
            $message =  "تعداد مجاز استفاده از کپن به پایان رسیده است";
            $validationCode = 4;
        }


        return [
            $message ,
            $validationCode
            ];
    }

    /**
     * @return string
     * Converting Created_at field to jalali
     */
    public function CreatedAt_Jalali()
    {
        $explodedDateTime = explode(" ", $this->created_at);
//        $explodedTime = $explodedDateTime[1] ;
        return $this->convertDate($this->created_at, "toJalali");
    }

    /**
     * @return string
     * Converting Updated_at field to jalali
     */
    public function UpdatedAt_Jalali()
    {
        $explodedDateTime = explode(" ", $this->updated_at);
//        $explodedTime = $explodedDateTime[1] ;
        return $this->convertDate($this->updated_at, "toJalali");
    }

    /**
     * @return string
     * Converting validSince field to jalali
     */
    public function ValidSince_Jalali()
    {
        $explodedDateTime = explode(" ", $this->validSince);
        $explodedTime = $explodedDateTime[1];
        $explodedDate = $this->convertDate($this->validSince, "toJalali");
        return ($explodedDate . " " . $explodedTime);
    }

    /**
     * @return string
     * Converting validUntil field to jalali
     */
    public function ValidUntil_Jalali()
    {
        $explodedDateTime = explode(" ", $this->validUntil);
        $explodedTime = $explodedDateTime[1];
        $explodedDate = $this->convertDate($this->validUntil, "toJalali");
        return ($explodedDate . " " . $explodedTime);
    }
}
