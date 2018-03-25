<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ordermanagercomment extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'order_id',
        'comment'
    ];

    public function order(){
        return $this->belongsTo('App\Order');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
}
