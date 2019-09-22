<?php

namespace App;

/**
 * App\Orderproducttype
 *
 * @property int                                                        $id
 * @property string|null                                                $name        نام
 * @property string|null                                                $displayName نام قابل نمایش
 * @property string|null                                                $description توضیح
 * @property \Carbon\Carbon|null                                        $created_at
 * @property \Carbon\Carbon|null                                        $updated_at
 * @property \Carbon\Carbon|null                                        $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Order[] $orders
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Orderproducttype onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderproducttype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderproducttype whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderproducttype whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderproducttype whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderproducttype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderproducttype whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderproducttype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Orderproducttype withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Orderproducttype withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderproducttype newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderproducttype newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Orderproducttype query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                 $cache_cooldown_seconds
 * @property-read int|null $orders_count
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
