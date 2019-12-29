<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Majortype
 *
 * @property int                                                   $id
 * @property string|null                                           $name        نام رشته
 * @property string|null                                           $displayName نام قابل نمایش رشته
 * @property string|null                                           $description توضیج درباره نوع رشته
 * @property Carbon|null                                   $created_at
 * @property Carbon|null                                   $updated_at
 * @property Carbon|null                                   $deleted_at
 * @property-read Collection|Major[] $majors
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Majortype onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Majortype whereCreatedAt($value)
 * @method static Builder|Majortype whereDeletedAt($value)
 * @method static Builder|Majortype whereDescription($value)
 * @method static Builder|Majortype whereDisplayName($value)
 * @method static Builder|Majortype whereId($value)
 * @method static Builder|Majortype whereName($value)
 * @method static Builder|Majortype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Majortype withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Majortype withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Majortype newModelQuery()
 * @method static Builder|Majortype newQuery()
 * @method static Builder|Majortype query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                 $cache_cooldown_seconds
 * @property-read int|null                                              $majors_count
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
