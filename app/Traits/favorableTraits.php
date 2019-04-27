<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2018-10-27
 * Time: 18:44
 */

namespace App\Traits;

use App\Events\FavoriteEvent;
use App\User;

trait favorableTraits
{
    public function favoring(User $user)
    {
        $this->favoriteBy()
            ->sync($user, false);
        event(new FavoriteEvent($user, $this));
    }
    
    /**
     * Get all of the users that favorite this
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function favoriteBy()
    {
        return $this->morphToMany('App\User', 'favorable')
            ->withTimestamps();
    }
}