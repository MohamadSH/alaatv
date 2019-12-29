<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Orderstatus
 *
 * @property int                                                   $id
 * @property string|null                                           $name        نام این وضعیت
 * @property string|null                                           $displayName نام قابل نمایش این وضعیت
 * @property string|null                                           $description توضیحات این وضعیت
 * @property Carbon|null                                   $created_at
 * @property Carbon|null                                   $updated_at
 * @property Carbon|null                                   $deleted_at
 * @property-read Collection|Order[] $orders
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Orderstatus onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Orderstatus whereCreatedAt($value)
 * @method static Builder|Orderstatus whereDeletedAt($value)
 * @method static Builder|Orderstatus whereDescription($value)
 * @method static Builder|Orderstatus whereDisplayName($value)
 * @method static Builder|Orderstatus whereId($value)
 * @method static Builder|Orderstatus whereName($value)
 * @method static Builder|Orderstatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Orderstatus withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Orderstatus withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Orderstatus newModelQuery()
 * @method static Builder|Orderstatus newQuery()
 * @method static Builder|Orderstatus query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                 $cache_cooldown_seconds
 * @property-read int|null                                              $orders_count
 */
class Orderstatus extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'displayName',
        'description',
    ];

    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}
