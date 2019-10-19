<?php

namespace App;

/**
 * App\Disk
 *
 * @property int                                                       $id
 * @property int|null                                                  $disktype_id آی دی مشخص کننده نوع دیسک
 * @property string                                                    $name        نام دیسک
 * @property \Carbon\Carbon|null                                       $created_at
 * @property \Carbon\Carbon|null                                       $updated_at
 * @property \Carbon\Carbon|null                                       $deleted_at
 * @property-read \App\Disktype|null                                   $disktype
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\File[] $files
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Disk onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Disk whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Disk whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Disk whereDisktypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Disk whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Disk whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Disk whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Disk withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Disk withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Disk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Disk newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Disk query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                $cache_cooldown_seconds
 * @property-read int|null $files_count
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
