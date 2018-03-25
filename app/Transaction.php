<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Helpers\Helper;
use Illuminate\Support\Facades\Config;

class Transaction extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'order_id',
        'cost',
        'authority',
        'transactionID',
        'traceNumber' ,
        'referenceNumber',
        'paycheckNumber',
        'managerComment',
        'sourceBankAccount_id',
        'destinationBankAccount_id',
        'paymentmethod_id',
        'transactiongateway_id',
        'transactionstatus_id',
        'completed_at'
    ];

    public function transactiongateway()
    {
        return $this->belongsTo('App\Transactiongateway');
    }

    public function order(){
        return $this->belongsTo('App\Order');
    }

    public function transactionstatus(){
        return $this->belongsTo('App\Transactionstatus');
    }

    public function paymentmethod(){
        return $this->belongsTo('\App\Paymentmethod');
    }

    public function sourceBankAccount(){
        return $this->belongsTo('\App\Bankaccount', 'bankaccounts', 'sourceBankAccount_id', 'id');
    }

    public function destinationBankAccount(){
        return $this->belongsTo('\App\Bankaccount', 'bankaccounts', 'destinationBankAccount_id', 'id');
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
     * Converting Created_at field to jalali
     */
    public function CompletedAt_Jalali(){
        $helper = new Helper();
        $explodedDateTime = explode(" " , $this->completed_at);
//        $explodedTime = $explodedDateTime[1] ;
        return $helper->convertDate($this->completed_at , "toJalali" );
    }

    /**
     * @return string
     * Converting Created_at field to jalali
     */
        public function DeadlineAt_Jalali(){
        $helper = new Helper();
        $explodedDateTime = explode(" " , $this->deadline_at);
//        $explodedTime = $explodedDateTime[1] ;
        return $helper->convertDate($this->deadline_at , "toJalali" );
    }

    public function parents(){
        return $this->belongsToMany('App\Transaction', 'transaction_transaction', 't2_id', 't1_id')
            ->withPivot('relationtype_id' )
            ->join('transactioninterraltions', 'relationtype_id', 'transactioninterraltions.id')
//            ->select('major1_id AS id', 'majorinterrelationtypes.name AS pivot_relationName' , 'majorinterrelationtypes.displayName AS pivot_relationDisplayName')
            ->where("relationtype_id" , Config::get("constants.TRANSACTION_INTERRELATION_PARENT_CHILD"));
    }

    public function children(){
        return $this->belongsToMany('App\Transaction', 'transaction_transaction', 't1_id', 't2_id')
            ->withPivot('relationtype_id' )
            ->join('transactioninterraltions', 'relationtype_id', 'contenttypeinterraltions.id')
            ->where("relationtype_id" , Config::get("constants.TRANSACTION_INTERRELATION_PARENT_CHILD"));
    }

    public function hasParents($depth = 1){
        $counter = 0;
        $myTransaction = $this;
        while(!$myTransaction->parents->isEmpty())
        {
            if($counter >= $depth) break ;
            $myTransaction = $myTransaction->parents->first() ;
            $counter++ ;
        }
        if($myTransaction->id == $this->id || $counter != $depth) return false ;
        else return true;
    }

    public function getGrandParent()
    {
        $counter = 1 ;
        $parentsArray = array();
        $myTransaction = $this ;
        while($myTransaction->hasParents())
        {
            $parentsArray = array_add($parentsArray , $counter++ , $myTransaction->parents->first() );
            $myTransaction = $myTransaction->parents->first() ;
        }
        if(empty($parentsArray))
            return false;
        else
            return array_last($parentsArray) ;
    }

    public function getCode()
    {
        if(isset($this->transactionID)) return "شماره تراکنش: ".$this->transactionID ;
        elseif(isset($this->traceNumber)) return "شماره پیگیری: ".$this->traceNumber ;
        elseif(isset($this->referenceNumber)) return "شماره مرجع: ".$this->referenceNumber ;
        elseif(isset($this->paycheckNumber)) return "شماره چک: ".$this->paycheckNumber ;
        else return false;
    }

}
