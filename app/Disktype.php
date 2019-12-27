<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Disktype
 *
 * @property int                                                  $id
 * @property string                                               $name نام نوع دیسک
 * @property Carbon|null                                  $created_at
 * @property Carbon|null                                  $updated_at
 * @property Carbon|null                                  $deleted_at
 * @property-read Collection|Disk[] $disks
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Disktype onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Disktype whereCreatedAt($value)
 * @method static Builder|Disktype whereDeletedAt($value)
 * @method static Builder|Disktype whereId($value)
 * @method static Builder|Disktype whereName($value)
 * @method static Builder|Disktype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Disktype withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Disktype withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Disktype newModelQuery()
 * @method static Builder|Disktype newQuery()
 * @method static Builder|Disktype query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                $cache_cooldown_seconds
 * @property-read int|null                                             $disks_count
 */
class Disktype extends BaseModel
{
    protected $fillable = [
        'name',
    ];

    public function disks()
    {
        return $this->hasMany("\App\Disk");
    }
}
