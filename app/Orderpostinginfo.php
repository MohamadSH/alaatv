<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Orderpostinginfo
 *
 * @property int                 $id
 * @property int                 $order_id آی دی مشخص کننده سفارش این پست
 * @property int                 $user_id  آی دی مشخص کننده مسئول درج کننده اطلاعات پستی
 * @property string|null         $postCode کد پست (شماره مرسوله)
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Order          $order
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Orderpostinginfo onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Orderpostinginfo whereCreatedAt($value)
 * @method static Builder|Orderpostinginfo whereDeletedAt($value)
 * @method static Builder|Orderpostinginfo whereId($value)
 * @method static Builder|Orderpostinginfo whereOrderId($value)
 * @method static Builder|Orderpostinginfo wherePostCode($value)
 * @method static Builder|Orderpostinginfo whereUpdatedAt($value)
 * @method static Builder|Orderpostinginfo whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Orderpostinginfo withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Orderpostinginfo withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Orderpostinginfo newModelQuery()
 * @method static Builder|Orderpostinginfo newQuery()
 * @method static Builder|Orderpostinginfo query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed          $cache_cooldown_seconds
 */
class Orderpostinginfo extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'postCode',
    ];

    public function order()
    {
        return $this->belongsTo(Order::Class);
    }
}
