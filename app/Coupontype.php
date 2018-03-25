<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupontype extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'displayName' ,
        'description',
    ];

    public function coupons(){
        return $this->hasMany('App\Coupon');
    }
}
