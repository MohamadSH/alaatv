<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transactiongateway extends Model
{
    use SoftDeletes;
    /**      * The attributes that should be mutated to dates.        */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'displayName',
        'description',
        'merchantNumber',
        'enable',
        'order',
        'bank_id',
        'merchantPassword',
        'certificatePrivateKeyFile',
        'certificatePrivateKeyPassword'

    ];

    public function transactions()
    {
        return $this->hasMany('\App\Transaction');
    }
}
