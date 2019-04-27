<?php

namespace App\Traits;

use App\Http\Controllers\WalletController;
use App\Http\Requests\Request;
use App\Wallet;

trait HasWallet
{
    /**
     * Retrieve the wallet of this user
     *
     * @return mixed
     */
    public function wallets()
    {
        return $this->hasMany('\App\Wallet');
    }
    
    /**
     * Retrieve the balance of all of this user's wallet
     */
    public function getTotalWalletBalance()
    {
        $wallets      = $this->wallets;
        $totalBalance = 0;
        foreach ($wallets as $wallet) {
            $totalBalance += $wallet->balance;
        }
        
        return $totalBalance;
    }
    
    /**
     * Determine if the user can withdraw the given amount
     *
     * @param  integer  $amount
     *
     * @return boolean
     */
    public function canWithdraw($amount)
    {
        return $this->getWalletBalance() >= $amount;
    }
    
    /**
     * Retrieve the balance of this user's wallet
     *
     * @param  int  $type
     *
     * @return int
     */
    public function getWalletBalance($type = 1)
    {
        $wallet  = $this->wallets->where("wallettype_id", $type)
            ->first();
        $balance = 0;
        if (isset($wallet)) {
            $balance = $this->wallets->where("wallettype_id", $type)
                ->first()->balance;
        }
        
        return $balance;
    }
    
    /**
     * Fail to move credits to this account
     *
     * @param  integer  $amount
     * @param  string   $type
     * @param  array    $meta
     */
    public function failDeposit($amount, $type = 'deposit', $meta = [])
    {
        $this->deposit($amount, $type, $meta, false);
    }
    
    /**
     * Move credits to this account
     *
     * @param  integer  $amount
     * @param  null     $walletType
     *
     * @return array
     */
    public function deposit($amount = 0, $walletType = null)
    {
        $failed       = true;
        $responseText = "";
        
        if (!isset($walletType)) {
            $walletType = config("constants.WALLET_TYPE_MAIN");
        }
        $wallet = $this->wallets->where("wallettype_id", $walletType)
            ->first();
        if (isset($wallet)) {
            $result = $wallet->deposit($amount);
            if ($result["result"]) {
                $failed = false;
            }
            else {
                $failed       = true;
                $responseText = $result["responseText"];
            }
        }
        else {
            $walletController = new WalletController();
            $request          = new Request();
            
            $request->offsetSet("user_id", $this->id);
            $request->offsetSet("wallettype_id", $walletType);
            RequestCommon::convertRequestToAjax($request);
            $response = $walletController->store($request);
            if ($response->getStatusCode() == 200) {
                $result = json_decode($response->getContent());
                $wallet = Wallet::where("id", $result->wallet->id)
                    ->first();
                $wallet->deposit($amount);
                $failed = false;
            }
            else {
                $failed       = true;
                $responseText = "CAN_NOT_CREATE_WALLET";
            }
        }
        
        if (!$failed) {
            $responseText = "SUCCESSFUL";
        }
        
        return [
            "result"       => !$failed,
            "responseText" => $responseText,
            "wallet"       => (isset($wallet)) ? $wallet->id : 0,
        ];
    }
    
    /**
     * Move credits from this account
     *
     * @param  integer  $amount
     * @param           $walletType
     *
     * @return array
     */
    public function forceWithdraw($amount, $walletType)
    {
        if (!isset($walletType)) {
            $walletType = config("constants.WALLET_TYPE_MAIN");
        }
        
        return $this->withdraw($amount, $walletType, false);
    }
    
    /**
     * Attempt to move credits from this account
     *
     * @param  integer  $amount
     * @param  null     $walletType
     * @param  boolean  $shouldAccept
     *
     * @return array
     */
    public function withdraw($amount, $walletType = null, $shouldAccept = true)
    {
        $failed       = true;
        $responseText = "";
        
        if (!isset($walletType)) {
            $walletType = config("constants.WALLET_TYPE_MAIN");
        }
        
        $wallet = $this->wallets->where("wallettype_id", $walletType)
            ->first();
        if (isset($wallet)) {
            $result = $wallet->withdraw($amount);
            if ($result["result"]) {
                $failed = false;
            }
            else {
                $failed       = true;
                $responseText = $result["responseText"];
            }
        }
        else {
            $walletController = new WalletController();
            $request          = new Request();
            
            $request->offsetSet("user_id", $this->id);
            $request->offsetSet("wallettype_id", $walletType);
            RequestCommon::convertRequestToAjax($request);
            $response = $walletController->store($request);
            if ($response->getStatusCode() == 200) {
                $result = json_decode($response->getContent());
                $wallet = Wallet::where("id", $result->wallet->id)
                    ->first();
                $wallet->deposit(0);
                $failed = false;
            }
            else {
                $failed       = true;
                $responseText = "CAN_NOT_CREATE_WALLET";
            }
        }
        
        if (!$failed) {
            $responseText = "SUCCESSFUL";
        }
        
        return [
            "result"       => !$failed,
            "responseText" => $responseText,
            "wallet"       => (isset($wallet)) ? $wallet->id : 0,
        ];
    }
    
    /**
     * Returns the actual balance for this wallet.
     * Might be different from the balance property if the database is manipulated
     *
     * @return void balance
     */
    public function actualBalance()
    {
        //        $credits = $this->wallet->transactions()
        //            ->whereIn('type', ['deposit', 'refund'])
        //            ->sum('amount');
        //        $debits = $this->wallet->transactions()
        //            ->whereIn('type', ['withdraw', 'payout'])
        //            ->sum('amount');
        //        return $credits - $debits;
    }
}