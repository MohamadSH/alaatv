<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2019-02-15
 * Time: 16:12
 */

namespace App\Traits\User;

use App\Collection\UserCollection;
use App\User;
use Cache;

trait EmployeeTrait
{
    /**
     * @return UserCollection
     */
    public static function getEmployee(): UserCollection
    {
        $key = "getEmployee";

        return Cache::tags(['employee'])
            ->remember($key, config("constants.CACHE_600"), function () {
                $employees = User::select()
                    ->role([config('constants.ROLE_EMPLOYEE')])
                    ->orderBy('lastName')
                    ->get();

                return $employees;
            });
    }

    public function employeeschedules()
    {
        return $this->hasMany("\App\Employeeschedule");
    }

    /*
    |--------------------------------------------------------------------------
    | static methods
    |--------------------------------------------------------------------------
    */

    public function employeetimesheets()
    {
        return $this->hasMany("\App\Employeetimesheet");
    }
}
