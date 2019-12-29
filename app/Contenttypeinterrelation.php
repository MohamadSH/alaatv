<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Contenttypeinterrelation
 *
 * @property int                 $id
 * @property string|null         $name        نام
 * @property string|null         $displayName نام قابل نمایش
 * @property string|null         $description توضیح
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Contenttypeinterrelation onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Contenttypeinterrelation whereCreatedAt($value)
 * @method static Builder|Contenttypeinterrelation whereDeletedAt($value)
 * @method static Builder|Contenttypeinterrelation whereDescription($value)
 * @method static Builder|Contenttypeinterrelation whereDisplayName($value)
 * @method static Builder|Contenttypeinterrelation whereId($value)
 * @method static Builder|Contenttypeinterrelation whereName($value)
 * @method static Builder|Contenttypeinterrelation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Contenttypeinterrelation withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Contenttypeinterrelation withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Contenttypeinterrelation newModelQuery()
 * @method static Builder|Contenttypeinterrelation newQuery()
 * @method static Builder|Contenttypeinterrelation query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed          $cache_cooldown_seconds
 */
class Contenttypeinterrelation extends BaseModel
{
    protected $fillable = [
        "name",
        "displayName",
        "description",
    ];
}
