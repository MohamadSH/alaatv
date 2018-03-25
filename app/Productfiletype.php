<?php

namespace App;

use Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Productfiletype extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description' ,
        'displayName',
    ];

    public function productfiles(){
        return $this->hasMany('\App\Productfile');
    }

    /**
     * @return string
     * Converting Created_at field to jalali
     */
    public function validSince_Jalali(){
        $helper = new Helper();
        $explodedDateTime = explode(" " , $this->validSince);
        $explodedTime = $explodedDateTime[1] ;
        return $helper->convertDate($this->validSince , "toJalali" )." ".$explodedTime;
    }
}
