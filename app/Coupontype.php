<?php

namespace App;

/**
 * App\Coupontype
 *
 * @property int                                                         $id
 * @property string|null                                                 $displayName نام قابل نمایش این نوع
 * @property string|null                                                 $name        نام این نوع در سیستم
 * @property string|null                                                 $description توضیحات این نوع
 * @property \Carbon\Carbon|null                                         $created_at
 * @property \Carbon\Carbon|null                                         $updated_at
 * @property \Carbon\Carbon|null                                         $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Coupon[] $coupons
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Coupontype onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupontype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupontype whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupontype whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupontype whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupontype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupontype whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupontype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Coupontype withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Coupontype withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupontype newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupontype newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupontype query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                  $cache_cooldown_seconds
 * @property-read int|null $coupons_count
 */
class Coupontype extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'displayName',
        'description',
    ];
    
    public function coupons()
    {
        return $this->hasMany('App\Coupon');
    }
}
