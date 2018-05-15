<?php

namespace App;

use App\Http\Controllers\WalletController;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

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

    /**
     * Determine if the user can withdraw from this wallet
     * @param  integer $amount
     * @return boolean
     */
    public function canWithdraw($amount)
    {
        return $this->balance >= $amount;
    }

    /**
     * Attempt to add credits to this wallet
     * @param  integer $amount
     * @param  string  $type
     * @param  array   $meta
     * @param  boolean $shouldAccept
     * @return array
     */
    public function withdraw( $amount , $orderId = null, $shouldAccept = true )
    {
        $failed = true;
        $responseText = "";

        $accepted = $shouldAccept ? $this->canWithdraw($amount) : true;

        if ($accepted)
        {
            $newBalance = $this->balance - $amount;
            $this->balance = $newBalance;
            $result =  $this->update();
            if($result)
            {
                $completed_at = Carbon::now();
                $transactionStatus = config("constants.TRANSACTION_STATUS_SUCCESSFUL") ;
                $paymentMethod = config("constants.PAYMENT_METHOD_WALLET") ;

                $this->transactions()
                    ->create([
                        'order_id'=>$orderId,
                        'wallet_id' => $this->id ,
                        'cost' => $amount,
                        'transactionstatus_id' => $transactionStatus,
                        'paymentmethod_id' => $paymentMethod,
                        'completed_at' => $completed_at,
                    ]);
                $responseText = "SUCCESSFUL";
                $failed = false;
            }
            else
            {
                $failed = true;
                $responseText = "CAN_NOT_UPDATE_WALLET";
            }
        }
        else
        {
            $failed = true;
            $responseText = "CAN_NOT_WITHDRAW";
        }

        return [
            "result" => !$failed ,
            "responseText" => $responseText,
        ] ;
    }

    /**
     * Force to move credits from this account
     * @param  integer $amount
     * @param  boolean $shouldAccept
     */
    public function forceWithdraw($amount)
    {
        return $this->withdraw($amount, false);
    }

    /**
     * Attempt to move credits from this wallet
     * @param  integer $amount
     * @param  string  $type
     * @param  array   $meta
     * @param  boolean $shouldAccept
     * @return array
     */
    public function deposit( $amount )
    {
        $failed = true;
        $responseText = "";

        $newBalance = $this->balance + $amount;
        $this->balance = $newBalance;
        $result =  $this->update();
        if($result)
        {
            $completed_at = Carbon::now();
            $transactionStatus = config("constants.TRANSACTION_STATUS_SUCCESSFUL") ;

            $this->transactions()
                ->create([
                    'wallet_id' => $this->id ,
                    'cost' => -$amount,
                    'transactionstatus_id' => $transactionStatus,
                    'completed_at' => $completed_at,
                ]);
            $responseText = "SUCCESSFUL";
            $failed = false;
        }
        else
        {
            $failed = true;
            $responseText = "CAN_NOT_UPDATE_WALLET";
        }

        return [
            "result" => !$failed ,
            "responseText" => $responseText,
        ] ;
    }
}
