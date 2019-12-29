<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Ordermanagercomment
 *
 * @property int                 $id
 * @property int|null            $user_id  آیدی مشخص کننده کاربر مسئول
 * @property int                 $order_id آیدی مشخص کننده سفارش
 * @property string|null         $comment  توضیح مسئول
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Order          $order
 * @property-read User|null      $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Ordermanagercomment onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Ordermanagercomment whereComment($value)
 * @method static Builder|Ordermanagercomment whereCreatedAt($value)
 * @method static Builder|Ordermanagercomment whereDeletedAt($value)
 * @method static Builder|Ordermanagercomment whereId($value)
 * @method static Builder|Ordermanagercomment whereOrderId($value)
 * @method static Builder|Ordermanagercomment whereUpdatedAt($value)
 * @method static Builder|Ordermanagercomment whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Ordermanagercomment withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Ordermanagercomment withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Ordermanagercomment newModelQuery()
 * @method static Builder|Ordermanagercomment newQuery()
 * @method static Builder|Ordermanagercomment query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed          $cache_cooldown_seconds
 */
class Ordermanagercomment extends BaseModel
{
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
