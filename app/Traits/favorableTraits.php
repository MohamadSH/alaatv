<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2018-10-27
 * Time: 18:44
 */

namespace App\Traits;

use App\Events\FavoriteEvent;
use App\Events\UnfavoriteEvent;
use App\User;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait favorableTraits
{
    public function favoring(User $user):bool
    {
        $syncResult = $this->favoriteBy()->sync($user, false);
        event(new FavoriteEvent($user, $this));
        return !empty($syncResult['attached']);
    }

    public function unfavoring(User $user):bool
    {
        $detachResult = $this->favoriteBy()->detach($user)  ;
        event(new UnfavoriteEvent($user, $this));
        return $detachResult;
    }

    /**
     * Get all of the users that favorite this
     *
     * @return HasMany
     */
    public function favoriteBy()
    {
        return $this->morphToMany('App\User', 'favorable')->withTimestamps();
    }
}
