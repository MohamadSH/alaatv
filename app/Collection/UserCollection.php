<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2018-09-03
 * Time: 19:06
 */

namespace App\Collection;


use Illuminate\Database\Eloquent\Collection;

class UserCollection  extends Collection
{
    public function roleFilter( $rolesId)
    {
        $users = $this->whereHas('roles', function ($q) use ($rolesId) {
            $q->whereIn("id", $rolesId);
        });
        return $users;
    }

}