<?php

namespace App;

/**
 * App\Majorinterrelationtypes
 *
 * @property int $id
 * @property string|null $name        نام نوع
 * @property string|null $displayName نام قابل نمایش نوع
 * @property string|null $description توضیح درباره این نوع رابطه
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Majorinterrelationtypes onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Majorinterrelationtypes whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Majorinterrelationtypes whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Majorinterrelationtypes whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Majorinterrelationtypes whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Majorinterrelationtypes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Majorinterrelationtypes whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Majorinterrelationtypes whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Majorinterrelationtypes withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Majorinterrelationtypes withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Majorinterrelationtypes newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Majorinterrelationtypes newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Majorinterrelationtypes query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed $cache_cooldown_seconds
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
