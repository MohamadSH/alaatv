<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Kalnoy\Nestedset\Collection;
use Kalnoy\Nestedset\NodeTrait;

/**
 * App\Category
 *
 * @mixin Eloquent
 * @property int                                          $id
 * @property string                                       $name
 * @property string|null                                  $description
 * @property int                                          $enable
 * @property string|null                                  $tags
 * @property Carbon|null              $created_at
 * @property Carbon|null              $updated_at
 * @property int                                          $_lft
 * @property int                                          $_rgt
 * @property int|null                                     $parent_id
 * @property-read Collection|Category[] $children
 * @property-read Category|null                           $parent
 * @method static Builder|Category d()
 * @method static Builder|Category whereCreatedAt($value)
 * @method static Builder|Category whereDescription($value)
 * @method static Builder|Category whereEnable($value)
 * @method static Builder|Category whereId($value)
 * @method static Builder|Category whereLft($value)
 * @method static Builder|Category whereName($value)
 * @method static Builder|Category whereParentId($value)
 * @method static Builder|Category whereRgt($value)
 * @method static Builder|Category whereTags($value)
 * @method static Builder|Category whereUpdatedAt($value)
 * @method static Builder|Category active()
 * @method static Builder|Category newModelQuery()
 * @method static Builder|Category newQuery()
 * @method static Builder|Category query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                   $cache_cooldown_seconds
 * @property-read int|null                                $children_count
 */
class Category extends Model
{
    use NodeTrait;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

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

    /**
     * Set the content's tag.
     *
     * @param array $value
     *
     * @return void
     */
    public function setTagsAttribute(array $value = null)
    {
        $tags = null;
        if (!empty($value)) {
            $tags = json_encode($value, JSON_UNESCAPED_UNICODE);
        }

        $this->attributes['tags'] = $tags;
    }
}
