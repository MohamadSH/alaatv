<?php

namespace App;

/**
 * App\Attributetype
 *
 * @property int                 $id
 * @property string|null         $name        نام این نوع
 * @property string|null         $description توضیح درباره این نوع
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Attributetype onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributetype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributetype whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributetype whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributetype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributetype whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributetype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Attributetype withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Attributetype withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributetype newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributetype newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributetype query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed          $cache_cooldown_seconds
 */
class Attributetype extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
    ];
}
