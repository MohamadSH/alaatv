<?php

namespace App;

use Illuminate\Support\Facades\Cache;
use Kalnoy\Nestedset\NodeTrait;

/**
 * App\Category
 *
 * @mixin \Eloquent
 * @property int                                               $id
 * @property string                                            $name
 * @property string|null                                       $description
 * @property int                                               $enable
 * @property string|null                                       $tags
 * @property \Illuminate\Support\Carbon|null                   $created_at
 * @property \Illuminate\Support\Carbon|null                   $updated_at
 * @property int                                               $_lft
 * @property int                                               $_rgt
 * @property int|null                                          $parent_id
 * @property-read \Kalnoy\Nestedset\Collection|\App\Category[] $children
 * @property-read \App\Category|null                           $parent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category d()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereLft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereRgt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 */
class Category extends BaseModel
{
    use NodeTrait;

    protected $fillable = [
        'name',
        'tags',
        'enable',
        'description',
    ];

    public function scopeActive($query)
    {
        return $query->where('enable', 1);
    }

    public function getWithDepth()
    {
        return Cache::tags('tree')
                    ->remember('tree', config('constants.CACHE_600'), function () {
                        return Category::withDepth()
                                       ->active()
                                       ->get();
                    });
    }
}
