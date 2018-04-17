<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Productphoto extends Model
{
    use SoftDeletes;
    /**      * The attributes that should be mutated to dates.        */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'file',
        'product_id'
    ];

    public function product()
    {
        return $this->belongsTo('\App\Product');
    }
}
