<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Phonetype
 *
 * @property int                                                   $id
 * @property string|null                                           $displayName نام قابل نمایش این نوع
 * @property string|null                                           $name        نام این نوع در سیستم
 * @property string|null                                           $description توضیحات این نوع
 * @property int                                                   $isEnable    نوع شماره تلفن فعال است یا خیر
 * @property Carbon|null                                   $created_at
 * @property Carbon|null                                   $updated_at
 * @property Carbon|null                                   $deleted_at
 * @property-read Collection|Phone[] $phones
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Phonetype onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Phonetype whereCreatedAt($value)
 * @method static Builder|Phonetype whereDeletedAt($value)
 * @method static Builder|Phonetype whereDescription($value)
 * @method static Builder|Phonetype whereDisplayName($value)
 * @method static Builder|Phonetype whereId($value)
 * @method static Builder|Phonetype whereIsEnable($value)
 * @method static Builder|Phonetype whereName($value)
 * @method static Builder|Phonetype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Phonetype withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Phonetype withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Phonetype newModelQuery()
 * @method static Builder|Phonetype newQuery()
 * @method static Builder|Phonetype query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                 $cache_cooldown_seconds
 * @property-read int|null                                              $phones_count
 */
class Phonetype extends BaseModel
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

    public function phones()
    {
        return $this->hasMany('\App\Phone');
    }
}
