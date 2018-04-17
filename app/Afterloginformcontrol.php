<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Afterloginformcontrol extends Model
{
    use SoftDeletes;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'displayName',
        'order'
    ];

    public static function getFormFields()
    {
        return Afterloginformcontrol::all()->where("enable", 1)->sortBy("order");
    }
}
