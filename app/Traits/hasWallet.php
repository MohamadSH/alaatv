<?php
namespace App\Traits;

use App\Http\Controllers\WalletController;
use App\Http\Requests\Request;
use App\Wallet;

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
        if(isset($wallet))
            return $this->wallets->where("wallettype_id" , $type)->first()->balance;
        else
            return 0 ;
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
        if(!isset($walletType))
            $walletType = config("constants.WALLET_TYPE_MAIN");
        if ($accepted)
        {
            $wallet = $this->wallets->where("wallettype_id" , $walletType)->first();
            if(isset($wallet))
            {
                $wallet->balance += $amount;
                $wallet->update();
                //ToDo: can use WalletController
            }
            else
            {
                $request = new Request();
                $request->offsetSet("user_id" , $this->id);
                $request->offsetSet("wallettype_id" , $walletType);
                $request->offsetSet("balance" , $amount);
                $request->offsetSet("fromAPI" , 1);
                $walletController = new WalletController();
                $response = $walletController->store($request);
                if($response->getStatusCode() == 200)
                {
                    //ToDo:
                }
                else
                {
                    //ToDo:
                }
            }
        }
        /*$this->wallet->transactions()
            ->create([
                'amount' => $amount,
                'hash' => uniqid('lwch_'),
                'type' => $type,
                'accepted' => $accepted,
                'meta' => $meta
            ]);*/
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
                    $wallet->balance -= $amount;
                    $wallet->update();
                    //ToDo: can use WalletController
                }
            }
            else
            {
                $request = new Request();
                $request->offsetSet("user_id" , $this->id);
                $request->offsetSet("wallettype_id" , $walletType);
                $request->offsetSet("balance" , -$amount);
                $request->offsetSet("fromAPI" , 1);
                $walletController =  new WalletController();
                $response =  $walletController->store($request);
                if($response->getStatusCode() == 200)
                {
                    //ToDo:
                }
                else
                {
                    //ToDo:
                }
            }

//        $this->wallet->transactions()
//            ->create([
//                'amount' => $amount,
//                'hash' => uniqid('lwch_'),
//                'type' => $type,
//                'accepted' => $accepted,
//                'meta' => $meta
//            ]);
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