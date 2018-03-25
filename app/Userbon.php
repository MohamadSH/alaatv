<?php

namespace App;

use Carbon\Carbon;
use Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Userbon extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'bon_id',
        'user_id' ,
        'totalNumber',
        'usedNumber',
        'validSince',
        'validUntil',
        'orderproduct_id',
        'userbonstatus_id'
    ];

    public function userbonstatus(){
        return $this->belongsTo('App\Userbonstatus');
    }

    public function bon(){
        return $this->belongsTo('\App\Bon');
    }

    public function user(){
        return $this->belongsTo('\App\User');
    }

    public function orderproducts(){
        return $this->belongsToMany('\App\Orderproduct');
    }

    public function orderproduct(){
        return $this->belongsTo('\App\Orderproduct');
    }

    /**
     * Validates a bon
     *
     * @return \Illuminate\Http\Response
     */
    public function validateBon(){
        if($this->totalNumber <= $this->usedNumber)
            return 0;
        elseif( isset($this->validSince) && Carbon::now() < $this->validSince)
            return 0;
        elseif( isset($this->validUntil) && Carbon::now() > $this->validUntil )
            return 0;
        else return $this->totalNumber - $this->usedNumber;
    }

    /**
     * @return string
     * Converting Created_at field to jalali
     */
    public function CreatedAt_Jalali(){
        $helper = new Helper();
        $explodedDateTime = explode(" " , $this->created_at);
//        $explodedTime = $explodedDateTime[1] ;
        return $helper->convertDate($this->created_at , "toJalali" );
    }

    /**
     * @return string
     * Converting Updated_at field to jalali
     */
    public function UpdatedAt_Jalali(){
        $helper = new Helper();
        $explodedDateTime = explode(" " , $this->updated_at);
//        $explodedTime = $explodedDateTime[1] ;
        return $helper->convertDate($this->updated_at , "toJalali" );
    }

}
