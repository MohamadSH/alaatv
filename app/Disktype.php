<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Disktype
 *
 * @property int                                                       $id
 * @property string                                                    $name نام نوع دیسک
 * @property \Carbon\Carbon|null                                       $created_at
 * @property \Carbon\Carbon|null                                       $updated_at
 * @property \Carbon\Carbon|null                                       $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Disk[] $disks
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Disktype onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Disktype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Disktype whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Disktype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Disktype whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Disktype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Disktype withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Disktype withoutTrashed()
 * @mixin \Eloquent
 */
class Disktype extends Model
{
    use SoftDeletes;

    /**      * The attributes that should be mutated to dates.        */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
    ];

    public function disks()
    {
        return $this->hasMany("\App\Disk");
    }
}
