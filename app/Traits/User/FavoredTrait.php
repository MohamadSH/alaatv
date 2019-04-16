<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2019-02-15
 * Time: 16:44
 */

namespace App\Traits\User;

trait FavoredTrait
{
    /*
    |--------------------------------------------------------------------------
    | relations
    |--------------------------------------------------------------------------
    */
    public function favoredContent()
    {
        return $this->morphedByMany('App\Content', 'favorable')->withTimestamps();
    }

    public function favoredSet()
    {
        return $this->morphedByMany('App\Contentset', 'favorable')->withTimestamps();
    }

    public function favoredProduct()
    {
        return $this->morphedByMany('App\Product', 'favorable')->withTimestamps();
    }
}