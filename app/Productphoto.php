<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Productphoto extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'file',
        'product_id'
    ];

    public function product(){
        return $this->belongsTo('\App\Product');
    }
}
