<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 10/17/2016
 * Time: 4:52 PM
 */

namespace App;

use App\Traits\DateTrait;
use App\Traits\Helper;
use Laratrust\Models\LaratrustRole;

/**
 * App\Role
 *
 * @property int                                                             $id
 * @property int                                                             $isDefault آیا نقش سیستمی است(نقش پیش فرض
 *           سیستمی)
 * @property string                                                          $name
 * @property string|null                                                     $display_name
 * @property string|null                                                     $description
 * @property \Carbon\Carbon|null                                             $created_at
 * @property \Carbon\Carbon|null                                             $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Permission[] $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[]       $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role query()
 * @property-read int|null $permissions_count
 * @property-read int|null $users_count
 */
class Role extends LaratrustRole
{
    use Helper;
    use DateTrait;
    
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'display_name',
        'description',
    ];
    
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    
    /*
     * it needs for deleting the role
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
