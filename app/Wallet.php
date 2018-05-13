<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallet extends Model
{
    use SoftDeletes;
    /**      * The attributes that should be mutated to dates.        */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'wallettype_id',
        'balance',
    ];

    /**
     * Retrieve all transactions
     */
    public function transactions()
    {
        return $this->hasMany("\App\Transaction");
    }
    /**
     * Retrieve owner
     */
    public function user()
    {
        return $this->belongsTo("\App\User");
    }
}
