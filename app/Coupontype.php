<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Coupontype
 *
 * @property int                                                    $id
 * @property string|null                                            $displayName نام قابل نمایش این نوع
 * @property string|null                                            $name        نام این نوع در سیستم
 * @property string|null                                            $description توضیحات این نوع
 * @property Carbon|null                                    $created_at
 * @property Carbon|null                                    $updated_at
 * @property Carbon|null                                    $deleted_at
 * @property-read Collection|Coupon[] $coupons
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Coupontype onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Coupontype whereCreatedAt($value)
 * @method static Builder|Coupontype whereDeletedAt($value)
 * @method static Builder|Coupontype whereDescription($value)
 * @method static Builder|Coupontype whereDisplayName($value)
 * @method static Builder|Coupontype whereId($value)
 * @method static Builder|Coupontype whereName($value)
 * @method static Builder|Coupontype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Coupontype withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Coupontype withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Coupontype newModelQuery()
 * @method static Builder|Coupontype newQuery()
 * @method static Builder|Coupontype query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                  $cache_cooldown_seconds
 * @property-read int|null                                               $coupons_count
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
