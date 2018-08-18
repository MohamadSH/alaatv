<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 10/17/2016
 * Time: 4:52 PM
 */

namespace App;

use App\Traits\Helper;
use Laratrust\Models\LaratrustRole;

/**
 * App\Role
 *
 * @property int $id
 * @property int $isDefault آیا نقش سیستمی است(نقش پیش فرض سیستمی)
 * @property string $name
 * @property string|null $display_name
 * @property string|null $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Permission[] $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Role extends LaratrustRole
{
    use Helper;
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'display_name',
        'description',
    ];

    /*
     * it needs for deleting the role
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    /**
     * @return string
     * Converting Created_at field to jalali
     */
    public function CreatedAt_Jalali()
    {
        $explodedDateTime = explode(" ", $this->created_at);
//        $explodedTime = $explodedDateTime[1] ;
        return $this->convertDate($this->created_at, "toJalali");
    }

    /**
     * @return string
     * Converting Updated_at field to jalali
     */
    public function UpdatedAt_Jalali()
    {
        $explodedDateTime = explode(" ", $this->updated_at);
//        $explodedTime = $explodedDateTime[1] ;
        return $this->convertDate($this->updated_at, "toJalali");
    }

}