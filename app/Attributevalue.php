<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attributevalue extends Model
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
        'attribute_id',
        'name',
        'description',
        'isDefault',
    ];

    public function attribute()
    {
        return $this->belongsTo('App\Attribute');
    }

    public function atributelabels()
    {
        return $this->hasMany('App\Attributelabel');
    }

    public function products()
    {
        return $this->belongsToMany('App\Product');
    }

    public function orderproducts()
    {
        return $this->belongsToMany('App\Orderproduct', 'attributevalue_orderproduct', 'value_id', 'orderproduct_id');
    }
}
