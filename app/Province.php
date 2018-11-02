<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Province
 *
 * @property int                                                       $id
 * @property string|null                                               $name نام استان
 * @property \Carbon\Carbon|null                                       $created_at
 * @property \Carbon\Carbon|null                                       $updated_at
 * @property \Carbon\Carbon|null                                       $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\City[] $cities
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Province onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Province whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Province whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Province whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Province whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Province whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Province withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Province withoutTrashed()
 * @mixin \Eloquent
 */
class Province extends Model
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
        'province_id',
        'name',
    ];

    public function cities()
    {
        return $this->hasMany('\App\City');
    }
}
