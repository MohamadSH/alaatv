<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Afterloginformcontrol extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'displayName' ,
        'order'
    ];

    public static function getFormFields()
    {
        return Afterloginformcontrol::all()->where("enable" , 1)->sortBy("order");
    }
}
