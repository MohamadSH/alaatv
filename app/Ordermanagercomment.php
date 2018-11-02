<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Ordermanagercomment
 *
 * @property int                 $id
 * @property int|null            $user_id  آیدی مشخص کننده کاربر مسئول
 * @property int                 $order_id آیدی مشخص کننده سفارش
 * @property string|null         $comment  توضیح مسئول
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \App\Order     $order
 * @property-read \App\User|null $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Ordermanagercomment onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ordermanagercomment whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ordermanagercomment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ordermanagercomment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ordermanagercomment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ordermanagercomment whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ordermanagercomment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ordermanagercomment whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ordermanagercomment withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Ordermanagercomment withoutTrashed()
 * @mixin \Eloquent
 */
class Ordermanagercomment extends Model
{
    use SoftDeletes;
    /**      * The attributes that should be mutated to dates.        */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'order_id',
        'comment',
    ];

    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
