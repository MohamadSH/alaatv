<?php

namespace App;

use App\Traits\DateTrait;
use App\Traits\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Relative
 *
 * @property int $id
 * @property string|null $name نام رکورد
 * @property string|null $displayName نام قابل نمایش رکورد
 * @property string|null $description توضیح رکورد
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Contact[] $contact
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Relative onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Relative whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Relative whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Relative whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Relative whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Relative whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Relative whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Relative whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Relative withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Relative withoutTrashed()
 * @mixin \Eloquent
 */
class Relative extends Model
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
     * @var array
     */
    protected $fillable = [
        'name',
        'displayName',
        'description',
    ];


    public function contact()
    {
        return $this->hasMany('\App\Contact');
    }
}
