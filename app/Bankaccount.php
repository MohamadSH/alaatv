<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bankaccount extends Model
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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'bank_id',
        'accountNumber',
        'cardNumber',
    ];

    public function user()
    {
        return $this->belongsTo('\App\User');
    }

    public function bank()
    {
        return $this->belongsTo('\App\Bank');
    }

    public function transactions()
    {
        return $this->hasMany('\App\Transaction');
    }
}
