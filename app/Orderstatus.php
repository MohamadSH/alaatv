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
