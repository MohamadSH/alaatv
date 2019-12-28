<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Disk
 *
 * @property int                    $id
 * @property int|null               $disktype_id آی دی مشخص کننده نوع دیسک
 * @property string                 $name        نام دیسک
 * @property Carbon|null    $created_at
 * @property Carbon|null    $updated_at
 * @property Carbon|null    $deleted_at
 * @property-read Disktype|null     $disktype
 * @property-read Collection|File[] $files
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Disk onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Disk whereCreatedAt($value)
 * @method static Builder|Disk whereDeletedAt($value)
 * @method static Builder|Disk whereDisktypeId($value)
 * @method static Builder|Disk whereId($value)
 * @method static Builder|Disk whereName($value)
 * @method static Builder|Disk whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Disk withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Disk withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Disk newModelQuery()
 * @method static Builder|Disk newQuery()
 * @method static Builder|Disk query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                $cache_cooldown_seconds
 * @property-read int|null                                             $files_count
 */
class Disk extends BaseModel
{
    protected $fillable = [
        'name',
        'disktype_id',
    ];

    public function disktype()
    {
        return $this->belongsTo("\App\Disktype");
    }

    public function files()
    {
        return $this->belongsToMany("\App\File")
            ->withPivot("priority");
    }
}
