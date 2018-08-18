<?php

namespace App;

use App\Traits\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Productfiletype
 *
 * @property int $id
 * @property string|null $name نام نوع
 * @property string|null $displayName نام قابل نمایش نوع
 * @property string|null $description نام قابل نمایش نوع
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Productfile[] $productfiles
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Productfiletype onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productfiletype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productfiletype whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productfiletype whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productfiletype whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productfiletype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productfiletype whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productfiletype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Productfiletype withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Productfiletype withoutTrashed()
 * @mixin \Eloquent
 */
class Productfiletype extends Model
{
    use SoftDeletes;
    use Helper;
    /**      * The attributes that should be mutated to dates.        */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'displayName',
    ];

    public function productfiles()
    {
        return $this->hasMany('\App\Productfile');
    }

    /**
     * @return string
     * Converting Created_at field to jalali
     */
    public function validSince_Jalali()
    {
        $explodedDateTime = explode(" ", $this->validSince);
        $explodedTime = $explodedDateTime[1];
        return $this->convertDate($this->validSince, "toJalali") . " " . $explodedTime;
    }
}
