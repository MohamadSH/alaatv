<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Orderfile
 *
 * @property int                 $id
 * @property int                 $order_id    آی دی مشخص کننده سفارشی که این فایل به آن تعلق دارد
 * @property int|null            $user_id     آی دی مشخص کننده کاربر آپلود کننده فایل
 * @property string              $file        فایل آپلود شده
 * @property string|null         $description توضیح درباره فایل
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Order          $order
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Orderfile onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Orderfile whereCreatedAt($value)
 * @method static Builder|Orderfile whereDeletedAt($value)
 * @method static Builder|Orderfile whereDescription($value)
 * @method static Builder|Orderfile whereFile($value)
 * @method static Builder|Orderfile whereId($value)
 * @method static Builder|Orderfile whereOrderId($value)
 * @method static Builder|Orderfile whereUpdatedAt($value)
 * @method static Builder|Orderfile whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Orderfile withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Orderfile withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Orderfile newModelQuery()
 * @method static Builder|Orderfile newQuery()
 * @method static Builder|Orderfile query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed          $cache_cooldown_seconds
 */
class Orderfile extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'order_id',
        'user_id',
        'file',
        'description',
    ];

    public function order()
    {
        return $this->belongsTo('\App\Order');
    }
}
