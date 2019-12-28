<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Contacttype
 *
 * @property int                                                     $id
 * @property string|null                                             $displayName نام قابل نمایش نوع
 * @property string|null                                             $name        نام این نوع در سیستم
 * @property string|null                                             $description توضیحات این نوع
 * @property int                                                     $isEnable    نوع دفترچه تلفن فعال است یا خیر
 * @property Carbon|null                                     $created_at
 * @property Carbon|null                                     $updated_at
 * @property Carbon|null                                     $deleted_at
 * @property-read Collection|Contact[] $contacts
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Contacttype onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Contacttype whereCreatedAt($value)
 * @method static Builder|Contacttype whereDeletedAt($value)
 * @method static Builder|Contacttype whereDescription($value)
 * @method static Builder|Contacttype whereDisplayName($value)
 * @method static Builder|Contacttype whereId($value)
 * @method static Builder|Contacttype whereIsEnable($value)
 * @method static Builder|Contacttype whereName($value)
 * @method static Builder|Contacttype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Contacttype withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Contacttype withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Contacttype newModelQuery()
 * @method static Builder|Contacttype newQuery()
 * @method static Builder|Contacttype query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                   $cache_cooldown_seconds
 * @property-read int|null                                                $contacts_count
 */
class Contacttype extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'displayName',
        'description',
        'isEnable',
    ];

    public function contacts()
    {
        return $this->hasMany('\App\Contact');
    }
}
