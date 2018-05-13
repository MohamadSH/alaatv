<?php
namespace App\Traits;

use App\Http\Controllers\WalletController;
use App\Http\Requests\Request;
use App\Wallet;
use Carbon\Carbon;

trait HasWallet
{
    /**
     * Retrieve the wallet of this user
     */
    public function wallets()
    {
        return $this->hasMany('\App\Wallet');
    }
    /**
     * Retrieve all transactions of this user
     */
    public function transactions()
    {
        return $this->hasManyThrough("\App\Transaction", "\App\Wallet")->latest();
    }

    /**
     * Retrieve the balance of this user's wallet
     */
    public function getWalletBalance($type = 1)
    {
        $wallet = $this->wallets->where("wallettype_id" , $type)->first();
        $balance = 0 ;
        if(isset($wallet))
            $balance = $this->wallets->where("wallettype_id" , $type)->first()->balance;

        return $balance ;
    }
    /**
     * Retrieve the balance of all of this user's wallet
     */
    public function getTotalWalletBalance()
    {
        $wallets = $this->wallets;
        $totalBalance = 0;
        foreach ($wallets as $wallet)
        {
            $totalBalance += $wallet->balance ;
        }

        return $totalBalance ;
    }
    /**
     * Determine if the user can withdraw the given amount
     * @param  integer $amount
     * @return boolean
     */
    public function canWithdraw($amount)
    {
        return $this->getWalletBalance() >= $amount;
    }
    /**
     * Move credits to this account
     * @param  integer $amount
     * @param  string  $type
     * @param  array   $meta
     */
    public function deposit($amount=0, $walletType=null , $type = 'deposit', $meta = [],  $accepted = true)
    {
        $failed = true;
        $responseText = "";
        $walletController = new WalletController();
        $request = new Request();

        if(!isset($walletType))
            $walletType = config("constants.WALLET_TYPE_MAIN");
        if ($accepted)
        {
            $wallet = $this->wallets->where("wallettype_id" , $walletType)->first();
            if(isset($wallet))
            {
                $newBalance = $wallet->balance + $amount;
                $request->offsetSet("balance" , $newBalance);
                $request->offsetSet("fromAPI" , 1);

                $response =  $walletController->update($request , $wallet);
                if($response->getStatusCode() == 200)
                {
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
                $request->offsetSet("user_id" , $this->id);
                $request->offsetSet("wallettype_id" , $walletType);
                $request->offsetSet("balance" , $amount);
                $request->offsetSet("fromAPI" , 1);
                $response =  $walletController->store($request);
                if($response->getStatusCode() == 200)
                {
                    $failed = false;
                    $result =  json_decode($response->getContent());
                    $wallet = Wallet::where("id" , $result->wallet->id)->first() ;
                }
                else
                {
                    $failed = true;
                    $responseText = "CAN_NOT_CREATE_WALLET";
                }
            }
        }
        if(isset($wallet) && !$failed)
        {
            $completed_at = Carbon::now();
            $transactionStatus = config("constants.TRANSACTION_STATUS_SUCCESSFUL") ;

            $wallet->transactions()
                ->create([
                    'wallet_id' => $wallet->id ,
                    'cost' => $amount,
                    'transactionstatus_id' => $transactionStatus,
                    'completed_at' => $completed_at,
                ]);

            $failed = false;
        }
        else
        {
            $failed = true;
            $responseText = "NO_WALLET_FOUND";
        }

        return [
        "result" => !$failed ,
        "responseText" => $responseText
    ] ;
    }
    /**
     * Fail to move credits to this account
     * @param  integer $amount
     * @param  string  $type
     * @param  array   $meta
     */
    public function failDeposit($amount, $type = 'deposit', $meta = [])
    {
        $this->deposit($amount, $type, $meta, false);
    }
    /**
     * Attempt to move credits from this account
     * @param  integer $amount
     * @param  string  $type
     * @param  array   $meta
     * @param  boolean $shouldAccept
     */
    public function withdraw( $amount , $walletType=null, $type = 'withdraw', $meta = [], $shouldAccept = true)
    {
            $failed = true;
            $responseText = "";
            $walletController =  new WalletController();
            $request = new Request();

            if(!isset($walletType))
                $walletType = config("constants.WALLET_TYPE_MAIN");

            $wallet = $this->wallets
                            ->where("wallettype_id" , $walletType)
                            ->first();
            if(isset($wallet))
            {
                $accepted = $shouldAccept ? $this->canWithdraw($amount) : true;
                if ($accepted)
                {
                    $newBalance = $wallet->balance - $amount;
                    $request->offsetSet("balance" , $newBalance);
                    $request->offsetSet("fromAPI" , 1);

                    $response =  $walletController->update($request , $wallet);
                    if($response->getStatusCode() == 200)
                    {
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
            }
            else
            {
                $request->offsetSet("user_id" , $this->id);
                $request->offsetSet("wallettype_id" , $walletType);
                $request->offsetSet("balance" , -$amount);
                $request->offsetSet("fromAPI" , 1);

                $response =  $walletController->store($request);
                if($response->getStatusCode() == 200)
                {
                    $result =  json_decode($response->getContent());
                    $wallet = Wallet::where("id" , $result->wallet->id)->first() ;
                    $failed = false ;
                }
                else
                {
                    $failed = true;
                    $responseText = "CAN_NOT_CREATE_WALLET";
                }
            }

            if(isset($wallet) && !$failed)
            {
                $completed_at = Carbon::now();
                $transactionStatus = config("constants.TRANSACTION_STATUS_SUCCESSFUL") ;

                $wallet->transactions()
                    ->create([
                        'wallet_id' => $wallet->id ,
                        'cost' => -$amount,
                        'transactionstatus_id' => $transactionStatus,
                        'completed_at' => $completed_at,
                    ]);
                $failed = false;
                $responseText = "SUCCESSFUL";
            }
            else
            {
                $failed = true;
                $responseText = "No_WALLET_FOUND";
            }
        return [
            "result" => !$failed ,
            "responseText" => $responseText
            ] ;
    }
    /**
     * Move credits from this account
     * @param  integer $amount
     * @param  string  $type
     * @param  array   $meta
     * @param  boolean $shouldAccept
     */
    public function forceWithdraw($amount, $type = 'withdraw', $walletType = 1 ,$meta = [])
    {
        return $this->withdraw($amount, $type,$walletType, $meta, false);
    }
    /**
     * Returns the actual balance for this wallet.
     * Might be different from the balance property if the database is manipulated
     * @return float balance
     */
    public function actualBalance()
    {
//ToDo Implement it according to transaction system
//        $credits = $this->wallet->transactions()
//            ->whereIn('type', ['deposit', 'refund'])
//            ->sum('amount');
//        $debits = $this->wallet->transactions()
//            ->whereIn('type', ['withdraw', 'payout'])
//            ->sum('amount');
//        return $credits - $debits;
    }
}