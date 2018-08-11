<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Productvoucher extends Model
{
    use SoftDeletes;
    /**      * The attributes that should be mutated to dates.        */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'product_id',
        'user_id',
        'code',
        'expirationdatetime',
        'enable',
        'description',
    ];

    public function products()
    {
        return $this->belongsTo('App\Product');
    }
}
