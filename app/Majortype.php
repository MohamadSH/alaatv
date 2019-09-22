<?php

namespace App;

/**
 * App\Majortype
 *
 * @property int                                                        $id
 * @property string|null                                                $name        نام رشته
 * @property string|null                                                $displayName نام قابل نمایش رشته
 * @property string|null                                                $description توضیج درباره نوع رشته
 * @property \Carbon\Carbon|null                                        $created_at
 * @property \Carbon\Carbon|null                                        $updated_at
 * @property \Carbon\Carbon|null                                        $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Major[] $majors
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Majortype onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Majortype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Majortype whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Majortype whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Majortype whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Majortype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Majortype whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Majortype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Majortype withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Majortype withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Majortype newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Majortype newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Majortype query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                 $cache_cooldown_seconds
 * @property-read int|null $majors_count
 */
class Majortype extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'displayName',
        'description',
    ];
    
    public function majors()
    {
        return $this->hasMany('\App\Major');
    }
}
