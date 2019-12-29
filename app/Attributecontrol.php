<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Attributecontrol
 *
 * @property int                                                       $id
 * @property string|null                                               $name        نام کنترل صفت
 * @property string|null                                               $description توضیح درباره کنترل
 * @property Carbon|null                                       $created_at
 * @property Carbon|null                                       $updated_at
 * @property Carbon|null                                       $deleted_at
 * @property-read Collection|Attribute[] $attributes
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Attributecontrol onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Attributecontrol whereCreatedAt($value)
 * @method static Builder|Attributecontrol whereDeletedAt($value)
 * @method static Builder|Attributecontrol whereDescription($value)
 * @method static Builder|Attributecontrol whereId($value)
 * @method static Builder|Attributecontrol whereName($value)
 * @method static Builder|Attributecontrol whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Attributecontrol withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Attributecontrol withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Attributecontrol newModelQuery()
 * @method static Builder|Attributecontrol newQuery()
 * @method static Builder|Attributecontrol query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                     $cache_cooldown_seconds
 * @property-read int|null                                                  $attributes_count
 */
class Attributecontrol extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
    ];

    public function attributes()
    {
        return $this->hasMany('App\Attribute');
    }
}
