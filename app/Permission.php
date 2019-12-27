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
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Laratrust\Models\LaratrustPermission;

/**
 * App\Permission
 *
 * @property int                                                  $id
 * @property string                                               $name
 * @property string|null                                          $display_name
 * @property string|null                                          $description
 * @property Carbon|null                                  $created_at
 * @property Carbon|null                                  $updated_at
 * @property-read Collection|Role[] $roles
 * @method static Builder|Permission whereCreatedAt($value)
 * @method static Builder|Permission whereDescription($value)
 * @method static Builder|Permission whereDisplayName($value)
 * @method static Builder|Permission whereId($value)
 * @method static Builder|Permission whereName($value)
 * @method static Builder|Permission whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static Builder|Permission newModelQuery()
 * @method static Builder|Permission newQuery()
 * @method static Builder|Permission query()
 * @property-read int|null                                             $roles_count
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
