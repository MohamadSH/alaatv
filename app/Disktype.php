<?php

namespace App;

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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Disktype newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Disktype newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Disktype query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                $cache_cooldown_seconds
 * @property-read int|null $disks_count
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
