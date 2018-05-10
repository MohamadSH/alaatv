<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 10/17/2016
 * Time: 4:52 PM
 */

namespace App;

use App\Traits\Helper;
use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
    use Helper;
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'display_name',
        'description',
    ];

    /*
     * it needs for deleting the role
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    /**
     * @return string
     * Converting Created_at field to jalali
     */
    public function CreatedAt_Jalali()
    {
        $explodedDateTime = explode(" ", $this->created_at);
//        $explodedTime = $explodedDateTime[1] ;
        return $this->convertDate($this->created_at, "toJalali");
    }

    /**
     * @return string
     * Converting Updated_at field to jalali
     */
    public function UpdatedAt_Jalali()
    {
        $explodedDateTime = explode(" ", $this->updated_at);
//        $explodedTime = $explodedDateTime[1] ;
        return $this->convertDate($this->updated_at, "toJalali");
    }

}