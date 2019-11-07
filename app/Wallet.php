<?php

namespace App;

use Carbon\Carbon;

/**
 * App\Wallet
 *
 * @property int                                                              $id
 * @property int|null                                                         $user_id       آیدی مشخص کننده کاربر صاحب
 *           کیف پول
 * @property int|null                                                         $wallettype_id آیدی مشخص کننده نوع کیف
 *           پول
 * @property int                                                              $balance       اعتبار کیف پول
 * @property \Carbon\Carbon|null                                              $created_at
 * @property \Carbon\Carbon|null                                              $updated_at
 * @property \Carbon\Carbon|null                                              $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Transaction[] $transactions
 * @property-read \App\User|null                                              $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Wallet onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Wallet whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Wallet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Wallet whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Wallet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Wallet whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Wallet whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Wallet whereWallettypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Wallet withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Wallet withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Wallet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Wallet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Wallet query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read \App\Wallettype|null                                        $walletType
 * @property-read mixed                                                       $cache_cooldown_seconds
 * @property int $pending_to_reduce مبلغی که علی الحساب از کیف پول کم شده است
 * @property-read int|null $transactions_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Wallet wherePendingToReduce($value)
 */
class Wallet extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'wallettype_id',
        'balance',
        'pending_to_reduce',
    ];

    /**
     * Retrieve owner
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Force to move credits from this account
     *
     * @param  integer  $amount
     *
     * @return array
     */
    public function forceWithdraw($amount)
    {
        return $this->withdraw($amount, false);
    }

    /**
     * Attempt to add credits to this wallet
     *
     * @param integer $amount
     * @param null $orderId
     * @param boolean $shouldAccept
     *
     * @param bool $withCreatingTransaction
     * @return array
     */
    public function withdraw($amount, $orderId = null, $shouldAccept = true , $withCreatingTransaction=true)
    {
        /**
         * unused variable
         */ /*$failed = true;*/
        /*$responseText = '';*/

        $accepted = $shouldAccept ? $this->canWithdraw($amount) : true;

        if ($amount > 0) {
            if ($accepted) {
                $newBalance    = $this->balance - $amount;
                $this->balance = $newBalance;
                $result        = $this->update();
                if ($result) {
                    $responseText = 'SUCCESSFUL';
                    $failed       = false;
                    if($withCreatingTransaction){
                        $this->transactions()
                            ->create([
                                'order_id'             => $orderId,
                                'wallet_id'            => $this->id,
                                'cost'                 => $amount,
                                'transactionstatus_id' => config('constants.TRANSACTION_STATUS_SUCCESSFUL'),
                                'paymentmethod_id'     => config('constants.PAYMENT_METHOD_WALLET'),
                                'completed_at'         => Carbon::now()->setTimezone('Asia/Tehran'),
                            ]);
                    }
                }
                else {
                    $failed       = true;
                    $responseText = 'CAN_NOT_UPDATE_WALLET';
                }
            }
            else {
                $failed       = true;
                $responseText = 'CAN_NOT_WITHDRAW';
            }

        }else{
            $failed       = true;
            $responseText = 'CAN_NOT_WITHDRAW';
        }

        return [
            'result'       => !$failed,
            'responseText' => $responseText,
        ];
    }

    /**
     * Determine if the user can withdraw from this wallet
     *
     * @param  integer  $amount
     *
     * @return boolean
     */
    public function canWithdraw($amount)
    {
        return $this->balance >= $amount;
    }

    /**
     * Retrieve all transactions
     */
    public function transactions()
    {
        return $this->hasMany('\App\Transaction');
    }

    /**
     * Attempt to move credits from this wallet
     *
     * @param  integer  $amount
     * @param  bool     $withoutTransaction
     *
     * @return array
     */
    public function deposit(int $amount, bool $withoutTransaction = false): array
    {
        /**
         * unused variable
         */

        if($amount > 0)
        {
            $newBalance    = $this->balance + $amount;
            $this->balance = $newBalance;
            $result        = $this->update();
            if ($result) {
                if (!$withoutTransaction) {
                    $transactionStatus = config('constants.TRANSACTION_STATUS_SUCCESSFUL');
                    $transaction = $this->transactions()
                                            ->create([
                                                'wallet_id'            => $this->id,
                                                'cost'                 => -$amount,
                                                'transactionstatus_id' => $transactionStatus,
                                                'completed_at'         => Carbon::now('Asia/Tehran'),
                                            ]);

                    if(isset($transaction)){
                        $responseText = 'SUCCESSFUL';
                        $failed       = false;
                    }else{
                        $failed       = true;
                        $responseText = 'CAN_NOT_UPDATE_WALLET';
                    }
                }else{
                    $responseText = 'SUCCESSFUL';
                    $failed       = false;
                }
            }
            else {
                $failed       = true;
                $responseText = 'CAN_NOT_UPDATE_WALLET';
            }
        }else{
            $failed       = true;
            $responseText = 'WRONG_AMOUNT';
        }

        return [
            'result'       => !$failed,
            'responseText' => $responseText,
        ];
    }

    public function walletType()
    {
        return $this->belongsTo('App\Wallettype', 'wallettype_id', 'id');
    }
}
