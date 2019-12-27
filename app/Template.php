<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Template
 *
 * @property int                                                     $id
 * @property string|null                                             $name نام
 * @property Carbon|null                                     $created_at
 * @property Carbon|null                                     $updated_at
 * @property Carbon|null                                     $deleted_at
 * @property-read Collection|Content[] $contents
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Template onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Template whereCreatedAt($value)
 * @method static Builder|Template whereDeletedAt($value)
 * @method static Builder|Template whereId($value)
 * @method static Builder|Template whereName($value)
 * @method static Builder|Template whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Template withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Template withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Template newModelQuery()
 * @method static Builder|Template newQuery()
 * @method static Builder|Template query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                   $cache_cooldown_seconds
 * @property-read int|null                                                $contents_count
 */
class Template extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function contents()
    {
        return $this->hasMany('\App\Content');
    }
}
