<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paymentstatus extends Model
{
    use SoftDeletes;
    /**      * The attributes that should be mutated to dates.        */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',

    ];

    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}
