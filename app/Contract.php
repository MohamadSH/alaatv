<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    /**      * The attributes that should be mutated to dates.        */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'since',
        'till'
    ];

    protected $fillable = [
        'name',
        'description',
        'user_id',
        'product_id',
        'registerer_id'
    ];

    public function user(){
        return $this->belongsTo(User::Class);
    }

    public function registerer(){
        return $this->belongsTo(User::Class);
    }

    public function product(){
        return $this->belongsTo(Product::Class);
    }
}
