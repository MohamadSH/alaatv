<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2019-02-15
 * Time: 17:24
 */

namespace App\Traits\User;

trait TrackTrait
{
    public function seensitepages()
    {
        return $this->belongsToMany('\App\Websitepage', 'userseensitepages', 'user_id', 'websitepage_id')
            ->withPivot("created_at", "numberOfVisit");
    }

    public function CanSeeCounter(): bool
    {
        return $this->hasRole("admin") ? true : false;
    }
}
