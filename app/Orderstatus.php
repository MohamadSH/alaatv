<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
 * @method static \Illuminate\Database\Query\Builder|Orderstatus onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|Orderstatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orderstatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orderstatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orderstatus whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orderstatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orderstatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orderstatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Orderstatus withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Orderstatus withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Orderstatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Orderstatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Orderstatus query()
 */
class Orderstatus extends Model
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
        'name',
        'displayName',
        'description',
    ];

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

}
