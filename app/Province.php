<?php

namespace App;

/**
 * App\Province
 *
 * @property int                                                       $id
 * @property string|null                                               $name نام استان
 * @property \Carbon\Carbon|null                                       $created_at
 * @property \Carbon\Carbon|null                                       $updated_at
 * @property \Carbon\Carbon|null                                       $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\City[] $cities
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Province onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Province whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Province whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Province whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Province whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Province whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Province withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Province withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Province newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Province newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Province query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                $cache_cooldown_seconds
 * @property-read int|null $cities_count
 */
class Province extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'province_id',
        'name',
    ];
    
    public function cities()
    {
        return $this->hasMany('\App\City');
    }
}
