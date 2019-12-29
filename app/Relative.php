<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Relative
 *
 * @property int                                                     $id
 * @property string|null                                             $name        نام رکورد
 * @property string|null                                             $displayName نام قابل نمایش رکورد
 * @property string|null                                             $description توضیح رکورد
 * @property Carbon|null                                     $created_at
 * @property Carbon|null                                     $updated_at
 * @property Carbon|null                                     $deleted_at
 * @property-read Collection|Contact[] $contact
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Relative onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Relative whereCreatedAt($value)
 * @method static Builder|Relative whereDeletedAt($value)
 * @method static Builder|Relative whereDescription($value)
 * @method static Builder|Relative whereDisplayName($value)
 * @method static Builder|Relative whereId($value)
 * @method static Builder|Relative whereName($value)
 * @method static Builder|Relative whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Relative withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Relative withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Relative newModelQuery()
 * @method static Builder|Relative newQuery()
 * @method static Builder|Relative query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                   $cache_cooldown_seconds
 * @property-read int|null                                                $contact_count
 */
class Relative extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'displayName',
        'description',
    ];

    public function contact()
    {
        return $this->hasMany('\App\Contact');
    }
}
