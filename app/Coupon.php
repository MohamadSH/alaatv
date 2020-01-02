<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

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
 * @property string|null               $code            کد کپن
 * @property float                     $discount        میزان تخفیف کپن به درصد
 * @property int|null                  $maxCost         بیشسینه قیمت مورد نیاز برای
 *           استفاده از این کپن
 * @property int|null                  $usageLimit      حداکثر تعداد مجاز تعداد
 *           استفاده از کپن - اگر نال باشد یعنی نامحدود
 * @property int                       $usageNumber     تعداد استفاده ها از کپن تا
 *           این لحظه
 * @property string|null               $validSince      تاریخ شروع معتبر بودن کپن
 * @property string|null               $validUntil      تاریخ پایان معتبر بودن کپن
 * @property Carbon|null               $created_at
 * @property Carbon|null               $updated_at
 * @property Carbon|null               $deleted_at
 * @property-read Coupontype|null      $coupontype
 * @property-read Discounttype|null    $discounttype
 * @property-read Collection|User[]    $marketers
 * @property-read Collection|Order[]   $orders
 * @property-read Collection|Product[] $products
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Coupon onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Coupon whereCoupontypeId($value)
 * @method static Builder|Coupon whereCreatedAt($value)
 * @method static Builder|Coupon whereDeletedAt($value)
 * @method static Builder|Coupon whereDescription($value)
 * @method static Builder|Coupon whereDiscount($value)
 * @method static Builder|Coupon whereDiscounttypeId($value)
 * @method static Builder|Coupon whereEnable($value)
 * @method static Builder|Coupon whereId($value)
 * @method static Builder|Coupon whereMaxCost($value)
 * @method static Builder|Coupon whereName($value)
 * @method static Builder|Coupon whereUpdatedAt($value)
 * @method static Builder|Coupon whereUsageLimit($value)
 * @method static Builder|Coupon whereUsageNumber($value)
 * @method static Builder|Coupon whereValidSince($value)
 * @method static Builder|Coupon whereValidUntil($value)
 * @method static \Illuminate\Database\Query\Builder|Coupon withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Coupon withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Coupon newModelQuery()
 * @method static Builder|Coupon newQuery()
 * @method static Builder|Coupon query()
 * @property-read mixed                                                   $coupon_type
 * @method static Builder|Coupon enable()
 * @method static Builder|Coupon valid()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @method static code($couponCode)
 * @property-read mixed                                                   $discount_type
 * @property-read mixed                                                   $cache_cooldown_seconds
 * @method static Builder|Coupon whereCode($value)
 * @property-read int|null                                                $marketers_count
 * @property-read int|null                                                $orders_count
 * @property-read int|null                                                $products_count
 */
class Coupon extends BaseModel
{
    /*
    |--------------------------------------------------------------------------
    | Traits
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */
    public const COUPON_VALIDATION_STATUS_OK = 0;
    public const COUPON_VALIDATION_STATUS_DISABLED = 1;
    public const COUPON_VALIDATION_STATUS_USAGE_TIME_NOT_BEGUN = 2;
    public const COUPON_VALIDATION_STATUS_EXPIRED = 3;
    public const COUPON_VALIDATION_STATUS_USAGE_LIMIT_FINISHED = 4;

    const COUPON_VALIDATION_INTERPRETER     = [
        self::COUPON_VALIDATION_STATUS_DISABLED             => 'Coupon is disabled',
        self::COUPON_VALIDATION_STATUS_USAGE_LIMIT_FINISHED => 'Coupon number is finished',
        self::COUPON_VALIDATION_STATUS_EXPIRED              => 'Coupon is expired',
        self::COUPON_VALIDATION_STATUS_USAGE_TIME_NOT_BEGUN => 'Coupon usage period has not started',
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
    protected $appends = [
        'couponType',
        'discountType',
    ];
    protected $hidden = [
        'id',
        'enable',
        'maxCost',
        'usageLimit',
        'usageNumber',
        'validSince',
        'validUntil',
        'created_at',
        'updated_at',
        'deleted_at',
        'coupontype_id',
        'discounttype_id',
    ];

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

    public function products()
    {
        return $this->belongsToMany('App\Product');
    }

    /**
     * Scope a query to only include enable(or disable) Coupons.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeEnable($query)
    {
        return $query->where('enable', '=', 1);
    }

    /**
     * Scope a query to only include valid Coupons.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeValid($query)
    {
        $now = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now('Asia/Tehran'));

        return $query->where(function ($q) use ($now) {
            $q->where('validSince', '<', $now)
                ->orWhereNull('validSince');
        })
            ->where(function ($q) use ($now) {
                $q->where('validUntil', '>', $now)
                    ->orWhereNull('validUntil');
            });
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
     * Scope a query by coupon code
     *
     * @param          $query
     * @param string   $code
     *
     * @return mixed
     */
    public function scopeCode($query, string $code)
    {
        return $query->where('code', $code);
    }

    /**
     * Validates a coupon
     *
     * @return int
     */
    public function validateCoupon()
    {

        if ($this->hasTotalNumberFinished()) {
            return self::COUPON_VALIDATION_STATUS_USAGE_LIMIT_FINISHED;
        }
        if (!$this->isEnable()) {
            return self::COUPON_VALIDATION_STATUS_DISABLED;
        }
        if (!$this->hasPassedSinceTime()) {
            return self::COUPON_VALIDATION_STATUS_USAGE_TIME_NOT_BEGUN;
        }
        if (!$this->hasTimeToUntilTime()) {
            return self::COUPON_VALIDATION_STATUS_EXPIRED;
        }

        return self::COUPON_VALIDATION_STATUS_OK;
    }

    /**
     * Determines whether this coupon is enabled or not
     *
     * @return bool
     */
    public function isEnable(): bool
    {
        return $this->enable ? true : false;
    }

    /*
    |--------------------------------------------------------------------------
    | Others
    |--------------------------------------------------------------------------
    */

    /**
     * Determines whether this coupon usage time has started or not
     *
     * @return bool
     */
    public function hasPassedSinceTime(): bool
    {
        return !isset($this->validSince) || Carbon::now()
                ->setTimezone('Asia/Tehran') >= $this->validSince;
    }

    /**
     * Determines whether this coupon usage time has ended or not
     *
     * @return bool
     */
    public function hasTimeToUntilTime(): bool
    {
        return !isset($this->validUntil) || Carbon::now()
                ->setTimezone('Asia/Tehran') <= $this->validUntil;
    }

    /**
     * Determines whether this coupon total number has finished or not
     *
     * @return bool
     */
    public function hasTotalNumberFinished(): bool
    {
        return isset($this->usageLimit) && $this->usageNumber >= $this->usageLimit;
    }

    public function getCouponTypeAttribute()
    {
        return optional($this->coupontype()
            ->first())->setVisible([
            'name',
            'displayName',
            'description',
        ]);
    }

    public function coupontype()
    {
        return $this->belongsTo('App\Coupontype');
    }

    /**
     * Determines whether this coupon has the passed product or not
     *
     * @param Product $product
     *
     * @return bool
     */
    public function hasProduct(Product $product): bool
    {

        if (in_array($product->id, [Product::CUSTOM_DONATE_PRODUCT, Product::DONATE_PRODUCT_5_HEZAR]))
            return false;

        $flag = true;
        if ($this->coupontype->id == config('constants.COUPON_TYPE_PARTIAL')) {
            $couponProducts = $this->products;
            $flag           = $couponProducts->contains($product);
        }

        return $flag;
    }

    public function decreaseUseNumber():self
    {
        $this->usageNumber = max($this->usageNumber - 1,0);
        return $this;
    }

    public function increaseUseNumber():self
    {
        $this->usageNumber++;
        return $this;
    }

    public function encreaseUserNumber()
    {
        $this->usageNumber++;
    }

    public function getDiscountTypeAttribute()
    {
        return optional($this->discounttype()
            ->first())
            ->setVisible([
                'name',
                'displayName',
                'description',
            ]);
    }

    public function discounttype()
    {
        return $this->belongsTo('\App\Discounttype');
    }
}
