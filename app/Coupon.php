<?php

namespace App;

use App\Collection\ProductCollection;
use App\Traits\DateTrait;
use App\Traits\Helper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * App\Coupon
 *
 * @property int                                                          $id
 * @property int|null                                                     $coupontype_id   آی دی مشخص کننده نوع کپن
 * @property int|null                                                     $discounttype_id نوع تخفیف
 * @property string|null                                                  $name            نام کپن
 * @property int                                                          $enable          فعال یا غیرفعال بودن کپن
 *           برای استفاده جدید
 * @property string|null                                                  $description     توضیحات کپن
 * @property string|null                                                  $code            کد کپن
 * @property float                                                        $discount        میزان تخفیف کپن به درصد
 * @property int|null                                                     $maxCost         بیشسینه قیمت مورد نیاز برای
 *           استفاده از این کپن
 * @property int|null                                                     $usageLimit      حداکثر تعداد مجاز تعداد
 *           استفاده از کپن - اگر نال باشد یعنی نامحدود
 * @property int                                                          $usageNumber     تعداد استفاده ها از کپن تا
 *           این لحظه
 * @property string|null                                                  $validSince      تاریخ شروع معتبر بودن کپن
 * @property string|null                                                  $validUntil      تاریخ پایان معتبر بودن کپن
 * @property \Carbon\Carbon|null                                          $created_at
 * @property \Carbon\Carbon|null                                          $updated_at
 * @property \Carbon\Carbon|null                                          $deleted_at
 * @property-read \App\Coupontype|null                                    $coupontype
 * @property-read \App\Discounttype|null                                  $discounttype
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[]    $marketers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Order[]   $orders
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon query()
 * @property-read mixed $coupon_type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon enable()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon valid()
 */
class Coupon extends Model
{

    /*
    |--------------------------------------------------------------------------
    | Traits
    |--------------------------------------------------------------------------
    */

    use SoftDeletes;
    use Helper;
    use DateTrait;


    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    /**      * The attributes that should be mutated to dates.        */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

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
        'discounttype_id',
    ];

    const COUPON_VALIDATION_STATUS_OK = 0;
    const COUPON_VALIDATION_STATUS_DISABLED = 1;
    const COUPON_VALIDATION_STATUS_USAGE_TIME_NOT_BEGUN = 2;
    const COUPON_VALIDATION_STATUS_EXPIRED = 3;
    const COUPON_VALIDATION_STATUS_USAGE_LIMIT_FINISHED = 4;

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

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

    /*
    |--------------------------------------------------------------------------
    | Accessor
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Scope a query to only include enable(or disable) Coupons.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEnable($query)
    {
        return $query->where('enable', '=', 1);
    }

    /**
     * Scope a query to only include valid Coupons.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeValid($query)
    {
        $now = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())
        ->timezone('Asia/Tehran');
        return $query
            ->where(function ($q) use ($now) {
                $q->where('validSince', '<', $now)
                    ->orWhereNull('validSince');
            })
            ->where(function ($q) use ($now){
                $q->where('validUntil', '>', $now)
                    ->orWhereNull('validUntil');
            });
    }

    /*
    |--------------------------------------------------------------------------
    | Others
    |--------------------------------------------------------------------------
    */

    /**
     * Validates a coupon
     *
     * @return int
     */
    public function validateCoupon()
    {

        $validationStatus = Coupon::COUPON_VALIDATION_STATUS_OK;
        if (!$this->isEnable()) {
            $validationStatus = Coupon::COUPON_VALIDATION_STATUS_DISABLED;
        }elseif(!$this->hasPassedSinceTime()) {
            $validationStatus = Coupon::COUPON_VALIDATION_STATUS_USAGE_TIME_NOT_BEGUN;
        }elseif(!$this->hasTimeToUntilTime()) {
            $validationStatus = Coupon::COUPON_VALIDATION_STATUS_EXPIRED;
        }elseif(!$this->hasTotalNumberFinished()) {
            $validationStatus = Coupon::COUPON_VALIDATION_STATUS_USAGE_LIMIT_FINISHED;
        }

        return $validationStatus;
    }

    /**
     * Determines whether this coupon is enabled or not
     *
     * @return bool
     */
    public function isEnable():bool
    {
        if($this->enable)
            return true ;
        else
            return false;
    }

    /**
     * Determines whether this coupon usage time has started or not
     *
     *  @return bool
     */
    public function hasPassedSinceTime():bool
    {
        if( !isset($this->validSince) || Carbon::now()->setTimezone("Asia/Tehran") >= $this->validSince)
            return true;
        else
            return false;
    }

    /**
     * Determines whether this coupon usage time has ended or not
     *
     *  @return bool
     */
    public function hasTimeToUntilTime():bool
    {
        if( !isset($this->validUntil) || Carbon::now()->setTimezone("Asia/Tehran") <= $this->validUntil)
            return true;
        else
            return false;
    }

    /**
     * Determines whether this coupon total number has finished or not
     *
     *  @return bool
     */
    public function hasTotalNumberFinished():bool
    {
        if(isset($this->usageLimit) && $this->usageNumber >= $this->usageLimit)
            return true;
        else
            return false ;
    }

    public function getCouponTypeAttribute()
    {
        if(!isset($this->coupontype_id))
            return config("constants.COUPON_TYPE_OVERALL");
        else
            return $this->coupontype_id;
    }

    /**
     * Determines whether this coupon has the passed product or not
     *
     * @param Product $product
     * @return bool
     */
    public function hasProduct(Product $product):bool
    {
        $flag = true;
        if ($this->coupon_type == config("constants.COUPON_TYPE_PARTIAL")) {
            $couponProducts = $this->products;
            $flag = $couponProducts->contains($product);
        }
        return $flag;
    }

}
