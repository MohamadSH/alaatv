<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Block extends Model
{
    protected $cascadeDeletes = [
        'blockables'
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $fillable = [
        'title',
        'tags',
        'order',
        'enable',
    ];

    public function getTagsAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * Scope a query to only include enable Blocks.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $enable
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
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->enable();
    }

    public static function getBlocks()
    {
        $blocks = Cache::tags('block')->remember('getBlocks', config('constants.CACHE_600'), function () {
            $blocks = Block::all()->sortByDesc('order')->loadMissing([
                'contents', 'sets', 'products'
            ]);
            return $blocks;
        });
        return $blocks;
    }

    public function contents()
    {
        return $this->morphedByMany('App\Content', 'blockable')->withTimestamps();
    }

    public function sets()
    {
        return $this->morphedByMany('App\Contentset', 'blockable')->withTimestamps();
    }

    public function products()
    {
        return $this->morphedByMany('App\Product', 'blockable')->withTimestamps();
    }
}
