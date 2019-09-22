<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 10/17/2016
 * Time: 4:56 PM
 */

namespace App;

use App\Traits\DateTrait;
use App\Traits\Helper;
use Laratrust\Models\LaratrustPermission;

/**
 * App\Permission
 *
 * @property int                                                       $id
 * @property string                                                    $name
 * @property string|null                                               $display_name
 * @property string|null                                               $description
 * @property \Carbon\Carbon|null                                       $created_at
 * @property \Carbon\Carbon|null                                       $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Role[] $roles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission query()
 * @property-read int|null $roles_count
 */
class Permission extends LaratrustPermission
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
}
