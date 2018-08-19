<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Orderfile
 *
 * @property int $id
 * @property int $order_id آی دی مشخص کننده سفارشی که این فایل به آن تعلق دارد
 * @property int|null $user_id آی دی مشخص کننده کاربر آپلود کننده فایل
 * @property string $file فایل آپلود شده
 * @property string|null $description توضیح درباره فایل
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \App\Order $order
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
 */
class Orderfile extends Model
{
    use SoftDeletes;
    /**      * The attributes that should be mutated to dates.        */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

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
