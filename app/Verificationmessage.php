<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Verificationmessage extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'code' ,
        'verificationmessagestatus_id',
        'expired_at'
    ];

    public function user(){
        return $this->belongsTo('\app\User');
    }

    public function verificationmessagestatus()
    {
        return $this->belongsTo('\app\Verificationmessagestatus');
    }
}
