<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Orderproducttype
 *
 * @property int                                                   $id
 * @property string|null                                           $name        نام
 * @property string|null                                           $displayName نام قابل نمایش
 * @property string|null                                           $description توضیح
 * @property Carbon|null                                   $created_at
 * @property Carbon|null                                   $updated_at
 * @property Carbon|null                                   $deleted_at
 * @property-read Collection|Order[] $orders
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Orderproducttype onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Orderproducttype whereCreatedAt($value)
 * @method static Builder|Orderproducttype whereDeletedAt($value)
 * @method static Builder|Orderproducttype whereDescription($value)
 * @method static Builder|Orderproducttype whereDisplayName($value)
 * @method static Builder|Orderproducttype whereId($value)
 * @method static Builder|Orderproducttype whereName($value)
 * @method static Builder|Orderproducttype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Orderproducttype withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Orderproducttype withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Orderproducttype newModelQuery()
 * @method static Builder|Orderproducttype newQuery()
 * @method static Builder|Orderproducttype query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                 $cache_cooldown_seconds
 * @property-read int|null                                              $orders_count
 */
class Orderproducttype extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'displayName',
    ];

    public function orders()
    {
        return $this->hasMany('\App\Order');
    }
}
