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
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Laratrust\Models\LaratrustRole;

/**
 * App\Role
 *
 * @property int                          $id
 * @property int                          $isDefault آیا نقش سیستمی است(نقش پیش فرض
 *           سیستمی)
 * @property string                       $name
 * @property string|null                  $display_name
 * @property string|null                  $description
 * @property Carbon|null          $created_at
 * @property Carbon|null          $updated_at
 * @property-read Collection|Permission[] $permissions
 * @property-read Collection|User[]       $users
 * @method static Builder|Role whereCreatedAt($value)
 * @method static Builder|Role whereDescription($value)
 * @method static Builder|Role whereDisplayName($value)
 * @method static Builder|Role whereId($value)
 * @method static Builder|Role whereIsDefault($value)
 * @method static Builder|Role whereName($value)
 * @method static Builder|Role whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static Builder|Role newModelQuery()
 * @method static Builder|Role newQuery()
 * @method static Builder|Role query()
 * @property-read int|null                                                   $permissions_count
 * @property-read int|null                                                   $users_count
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
