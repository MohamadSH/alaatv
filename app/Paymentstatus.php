<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Paymentstatus
 *
 * @property int                                                   $id
 * @property string|null                                           $name        نام این وضعیت
 * @property string|null                                           $displayName نام قابل نمایش این وضعیت
 * @property string|null                                           $description توضیح این وضعیت
 * @property Carbon|null                                   $created_at
 * @property Carbon|null                                   $updated_at
 * @property Carbon|null                                   $deleted_at
 * @property-read Collection|Order[] $orders
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Paymentstatus onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Paymentstatus whereCreatedAt($value)
 * @method static Builder|Paymentstatus whereDeletedAt($value)
 * @method static Builder|Paymentstatus whereDescription($value)
 * @method static Builder|Paymentstatus whereDisplayName($value)
 * @method static Builder|Paymentstatus whereId($value)
 * @method static Builder|Paymentstatus whereName($value)
 * @method static Builder|Paymentstatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Paymentstatus withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Paymentstatus withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Paymentstatus newModelQuery()
 * @method static Builder|Paymentstatus newQuery()
 * @method static Builder|Paymentstatus query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                 $cache_cooldown_seconds
 * @property-read int|null                                              $orders_count
 */
class Paymentstatus extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',

    ];

    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}
