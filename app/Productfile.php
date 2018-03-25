<?php

namespace App;

use Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Productfile extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'product_id',
        'productfiletype_id',
        'file',
        'name',
        'description' ,
        'order',
        'enable',
        'validSince',
        'cloudFile'
    ];

    public function product(){
        return $this->belongsTo('\App\Product');
    }

    public function productfiletype()
    {
        return $this->belongsTo('\App\Productfiletype');
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
