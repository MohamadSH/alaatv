<?php

namespace App;

/**
 * App\Orderfile
 *
 * @property int                 $id
 * @property int                 $order_id    آی دی مشخص کننده سفارشی که این فایل به آن تعلق دارد
 * @property int|null            $user_id     آی دی مشخص کننده کاربر آپلود کننده فایل
 * @property string              $file        فایل آپلود شده
 * @property string|null         $description توضیح درباره فایل
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \App\Order     $order
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Orderfile onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderfile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderfile whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderfile whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderfile whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderfile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderfile whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderfile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderfile whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Orderfile withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Orderfile withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderfile query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
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
