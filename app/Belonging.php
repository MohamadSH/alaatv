<?php

namespace App;

use App\Traits\DateTrait;
use App\Traits\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Belonging
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Belonging onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Belonging withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Belonging withoutTrashed()
 * @mixin \Eloquent
 */
class Belonging extends Model
{
    use SoftDeletes;
    use Helper;
    use DateTrait;
    /**      * The attributes that should be mutated to dates.        */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'file',
    ];

    public function users()
    {
        return $this->belongsToMany('\App\User');
    }
}
