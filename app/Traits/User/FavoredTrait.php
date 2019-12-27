<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2019-02-15
 * Time: 16:44
 */

namespace App\Traits\User;

use App\Content;
use App\Contentset;
use App\Product;
use Illuminate\Support\Facades\Cache;

trait FavoredTrait
{
    /*
    |--------------------------------------------------------------------------
    | relations
    |--------------------------------------------------------------------------
    */
    public function getActiveFavoredContents()
    {
        return Cache::tags(['favorite', 'user', 'user_' . $this->id, 'user_' . $this->id . '_favorites', 'user_' . $this->id . '_favoriteContents'])
            ->remember('user:favorite:contents:' . $this->cacheKey(), config('constants.CACHE_10'), function () {
                return $this->favoredContents()
                    ->active()
                    ->get()
                    ->sortBy('pivot.created_at');
            });
    }

    public function favoredContents()
    {
        return $this->morphedByMany(Content::class, 'favorable')->withTimestamps();
    }

    public function getActiveFavoredProducts()
    {
        return Cache::tags(['favorite', 'user', 'user_' . $this->id, 'user_' . $this->id . '_favorites', 'user_' . $this->id . '_favoriteProducts'])
            ->remember('user:favorite:products:' . $this->cacheKey(), config('constants.CACHE_10'), function () {
                return $this->favoredProducts()
                    ->active()
                    ->get()
                    ->sortByDesc('pivot.created_at');
            });
    }

    public function favoredProducts()
    {
        return $this->morphedByMany(Product::class, 'favorable')->withTimestamps();
    }

    public function getActiveFavoredSets()
    {
        return Cache::tags(['favorite', 'user', 'user_' . $this->id, 'user_' . $this->id . '_favorites', 'user_' . $this->id . '_favoriteSets'])
            ->remember('user:favorite:sets:' . $this->cacheKey(), config('constants.CACHE_10'), function () {
                return $this->favoredSets()
                    ->active()
                    ->get()
                    ->sortByDesc('pivot.created_at');
            });
    }

    public function favoredSets()
    {
        return $this->morphedByMany(Contentset::class, 'favorable')->withTimestamps();
    }
}
