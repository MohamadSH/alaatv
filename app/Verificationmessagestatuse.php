<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Verificationmessagestatuse extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'order',
    ];

    public function verificationmessages()
    {
        return $this->hasMany('App\Verificationmessage');
    }
}
