<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Grade
 *
 * @property int                                                     $id
 * @property string|null                                             $name        نام
 * @property string|null                                             $displayName نام قابل نمایش
 * @property string|null                                             $description توضیح
 * @property Carbon|null                                     $created_at
 * @property Carbon|null                                     $updated_at
 * @property Carbon|null                                     $deleted_at
 * @property-read Collection|Content[] $contents
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Grade onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Grade whereCreatedAt($value)
 * @method static Builder|Grade whereDeletedAt($value)
 * @method static Builder|Grade whereDescription($value)
 * @method static Builder|Grade whereDisplayName($value)
 * @method static Builder|Grade whereId($value)
 * @method static Builder|Grade whereName($value)
 * @method static Builder|Grade whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Grade withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Grade withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Grade newModelQuery()
 * @method static Builder|Grade newQuery()
 * @method static Builder|Grade query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                   $cache_cooldown_seconds
 * @property-read int|null                                                $contents_count
 */
class Grade extends BaseModel
{
    protected $fillable = [
        'name',
        'displayName',
        'description',
    ];

    public function contents()
    {
        return $this->belongsToMany('App\Content');
    }
}
