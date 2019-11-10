<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2018-10-28
 * Time: 12:36
 */

namespace App\Classes;

use App\User;
use Illuminate\Database\Eloquent\Relations\HasMany;

interface FavorableInterface
{
    /**
     * @return HasMany
     */
    public function favoriteBy();

    public function favoring(User $user);

    public function unfavoring(User $user);
}
