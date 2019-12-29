<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Bontype
 *
 * @property int                                                 $id
 * @property string                                              $name        نام نوع بن
 * @property string|null                                         $displayName نام قابل نمایش نوع بن
 * @property string|null                                         $description توضیح درباره نوع بن
 * @property Carbon|null                                 $created_at
 * @property Carbon|null                                 $updated_at
 * @property Carbon|null                                 $deleted_at
 * @property-read Collection|Bon[] $bons
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Bontype onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Bontype whereCreatedAt($value)
 * @method static Builder|Bontype whereDeletedAt($value)
 * @method static Builder|Bontype whereDescription($value)
 * @method static Builder|Bontype whereDisplayName($value)
 * @method static Builder|Bontype whereId($value)
 * @method static Builder|Bontype whereName($value)
 * @method static Builder|Bontype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Bontype withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Bontype withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Bontype newModelQuery()
 * @method static Builder|Bontype newQuery()
 * @method static Builder|Bontype query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                               $cache_cooldown_seconds
 * @property-read int|null                                            $bons_count
 */
class Bontype extends BaseModel
{
    protected $fillable = [
        'name',
        'displayName',
        'description',
    ];

    public function bons()
    {
        return $this->hasMany("\App\Bon");
    }
}
