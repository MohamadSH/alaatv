<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Orderpostinginfo
 *
 * @property int $id
 * @property int $order_id آی دی مشخص کننده سفارش این پست
 * @property int $user_id آی دی مشخص کننده مسئول درج کننده اطلاعات پستی
 * @property string|null $postCode کد پست (شماره مرسوله)
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \App\Order $order
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Orderpostinginfo onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderpostinginfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderpostinginfo whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderpostinginfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderpostinginfo whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderpostinginfo wherePostCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderpostinginfo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderpostinginfo whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Orderpostinginfo withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Orderpostinginfo withoutTrashed()
 * @mixin \Eloquent
 */
class Orderpostinginfo extends Model
{
    use SoftDeletes;
    /**      * The attributes that should be mutated to dates.        */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

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
        return $this->belongsTo('\App\Order');
    }

}
