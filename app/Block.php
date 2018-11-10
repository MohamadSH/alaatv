<?php

namespace App;


use App\Collection\BlockCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * App\Block
 *
 * @property int                                                   $id
 * @property string|null                                           $title
 * @property string|null                                           $tags
 * @property int                                                   $order
 * @property int                                                   $enable
 * @property \Illuminate\Support\Carbon|null                       $created_at
 * @property \Illuminate\Support\Carbon|null                       $updated_at
 * @property-read \App\Collection\ContentCollection|\App\Content[] $contents
 * @property-read \App\Collection\ProductCollection|\App\Product[] $products
 * @property-read \App\Collection\SetCollection|\App\Contentset[]  $sets
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block enable()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null                                           $class
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block query()
 */
class Block extends Model
{
    protected $cascadeDeletes = [
        'blockables',
    ];
    protected $dates          = [
        'created_at',
        'updated_at',
    ];
    protected $fillable       = [
        'title',
        'tags',
        'class',
        'order',
        'enable',
    ];

    public static function getBlocks()
    {
        $blocks = Cache::tags('block')
                       ->remember('getBlocks', config('constants.CACHE_600'), function () {
                           $blocks = Block::all()
                                          ->sortBy('order')
                                          ->loadMissing([
                                                            'contents',
                                                            'sets',
                                                            'products',
                                                        ]);
                           return $blocks;
                       });
        return $blocks;
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array $models
     *
     * @return BlockCollection
     */
    public function newCollection(array $models = [])
    {
        return new BlockCollection($models);
    }

    public function getTagsAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * Scope a query to only include enable Blocks.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int                                   $enable
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEnable($query)
    {
        return $query->where('enable', 1);
    }

    /**
     * Scope a query to only include active Contents.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->enable();
    }

    public function contents()
    {
        return $this->morphedByMany('App\Content', 'blockable')
                    ->withTimestamps();
    }

    public function sets()
    {
        return $this->morphedByMany('App\Contentset', 'blockable')
                    ->withTimestamps();
    }

    public function products()
    {
        return $this->morphedByMany('App\Product', 'blockable')
                    ->withTimestamps();
    }
}
