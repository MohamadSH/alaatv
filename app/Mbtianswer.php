<?php

namespace App;

use Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use Illuminate\Support\Facades\Config;

class Mbtianswer extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id' ,
        'answers' ,
    ];

    public function user()
    {
        return $this->belongsTo('\App\User');
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

    public function getUserOrderInfo($output){
        $ordooOrder =$this->user->orders()->whereHas('orderproducts', function($q)
        {
            $q->whereIn("product_id",  Product::whereHas('parents', function($q)
            {
                $q->whereIn("parent_id",  [1,13] );
            })->pluck("id") );
        })->whereIn("orderstatus_id" , [Config::get("constants.ORDER_STATUS_CLOSED")])->get();

        switch ($output)
        {
            case "productName":
                if($ordooOrder->isEmpty()) return "";
                else return $ordooOrder->first()->orderproducts->first()->product->name;
                break;
            case "orderStatus":
                if($ordooOrder->isEmpty()) return "";
                else return $ordooOrder->first()->orderstatus->displayName;
                break;
            default:
                break;
        }

    }
}
