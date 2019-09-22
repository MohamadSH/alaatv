<?php

namespace App;

/**
 * App\Orderstatus
 *
 * @property int                                                        $id
 * @property string|null                                                $name        نام این وضعیت
 * @property string|null                                                $displayName نام قابل نمایش این وضعیت
 * @property string|null                                                $description توضیحات این وضعیت
 * @property \Carbon\Carbon|null                                        $created_at
 * @property \Carbon\Carbon|null                                        $updated_at
 * @property \Carbon\Carbon|null                                        $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Order[] $orders
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Orderstatus onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderstatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderstatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderstatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderstatus whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderstatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderstatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderstatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Orderstatus withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Orderstatus withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderstatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderstatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderstatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                 $cache_cooldown_seconds
 * @property-read int|null $orders_count
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
