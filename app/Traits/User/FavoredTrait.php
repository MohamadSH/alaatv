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

trait FavoredTrait
{
    /*
    |--------------------------------------------------------------------------
    | relations
    |--------------------------------------------------------------------------
    */
    public function favoredContents()
    {
        return $this->morphedByMany(Content::class, 'favorable')->withTimestamps();
    }

    public function favoredSets()
    {
        return $this->morphedByMany(Contentset::class, 'favorable')->withTimestamps();
    }

    public function favoredProducts()
    {
        return $this->morphedByMany(Product::class, 'favorable')->withTimestamps();
    }
}
