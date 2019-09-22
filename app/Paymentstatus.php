<?php

namespace App;

/**
 * App\Paymentstatus
 *
 * @property int                                                        $id
 * @property string|null                                                $name        نام این وضعیت
 * @property string|null                                                $displayName نام قابل نمایش این وضعیت
 * @property string|null                                                $description توضیح این وضعیت
 * @property \Carbon\Carbon|null                                        $created_at
 * @property \Carbon\Carbon|null                                        $updated_at
 * @property \Carbon\Carbon|null                                        $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Order[] $orders
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Paymentstatus onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paymentstatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paymentstatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paymentstatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paymentstatus whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paymentstatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paymentstatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paymentstatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Paymentstatus withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Paymentstatus withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paymentstatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paymentstatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paymentstatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                 $cache_cooldown_seconds
 * @property-read int|null $orders_count
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
