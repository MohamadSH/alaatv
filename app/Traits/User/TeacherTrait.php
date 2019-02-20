<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2019-02-15
 * Time: 16:11
 */

namespace App\Traits\User;


use App\Collection\UserCollection;

trait TeacherTrait
{
    /**
     * @return UserCollection
     */
    public static function getTeachers(): UserCollection
    {
        $key = "getTeachers";
        return Cache::tags(["teachers"])
                    ->remember($key, config("constants.CACHE_600"), function () {
                        $authors = User::select()
                                       ->role([config('constants.ROLE_TEACHER')])
                                       ->orderBy('lastName')
                                       ->get();
                        return $authors;
                    });
    }

    /*
    |--------------------------------------------------------------------------
    | static methods
    |--------------------------------------------------------------------------
    */

    public function contents()
    {
        return $this->hasMany("\App\Content", "author_id", "id");
    }

}