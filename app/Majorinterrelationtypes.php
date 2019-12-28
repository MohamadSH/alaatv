<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Majorinterrelationtypes
 *
 * @property int                 $id
 * @property string|null         $name        نام نوع
 * @property string|null         $displayName نام قابل نمایش نوع
 * @property string|null         $description توضیح درباره این نوع رابطه
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Majorinterrelationtypes onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Majorinterrelationtypes whereCreatedAt($value)
 * @method static Builder|Majorinterrelationtypes whereDeletedAt($value)
 * @method static Builder|Majorinterrelationtypes whereDescription($value)
 * @method static Builder|Majorinterrelationtypes whereDisplayName($value)
 * @method static Builder|Majorinterrelationtypes whereId($value)
 * @method static Builder|Majorinterrelationtypes whereName($value)
 * @method static Builder|Majorinterrelationtypes whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Majorinterrelationtypes withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Majorinterrelationtypes withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Majorinterrelationtypes newModelQuery()
 * @method static Builder|Majorinterrelationtypes newQuery()
 * @method static Builder|Majorinterrelationtypes query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed          $cache_cooldown_seconds
 */
class Majorinterrelationtypes extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'displayName',
        'description',
    ];
}
