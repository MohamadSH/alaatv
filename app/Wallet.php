<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
 * @method static \Illuminate\Database\Query\Builder|Wallet onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereWallettypeId($value)
 * @method static \Illuminate\Database\Query\Builder|Wallet withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Wallet withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet query()
 */
class Wallet extends Model
{
    use SoftDeletes;
    /**      * The attributes that should be mutated to dates.        */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'wallettype_id',
        'balance',
    ];

    /**
     * Retrieve owner
     */
    public function user()
    {
        return $this->belongsTo("\App\User");
    }

    /**
     * Force to move credits from this account
     *
     * @param  integer $amount
     * @return array
     */
    public function forceWithdraw($amount)
    {
        return $this->withdraw($amount, false);
    }

    /**
     * Attempt to add credits to this wallet
     *
     * @param  integer $amount
     * @param null $orderId
     * @param  boolean $shouldAccept
     *
     * @return array
     */
    public function withdraw($amount, $orderId = null, $shouldAccept = true)
    {
        /**
         * unused variable
         */
        /*$failed = true;*/
        /*$responseText = "";*/

        $accepted = $shouldAccept ? $this->canWithdraw($amount) : true;

        if ($accepted) {
            $newBalance = $this->balance - $amount;
            $this->balance = $newBalance;
            $result = $this->update();
            if ($result) {
                if ($amount > 0) {
                    $completed_at = Carbon::now();
                    if (isset($orderId))
                        $transactionStatus = config("constants.TRANSACTION_STATUS_SUSPENDED");
                    else
                        $transactionStatus = config("constants.TRANSACTION_STATUS_SUCCESSFUL");
                    $paymentMethod = config("constants.PAYMENT_METHOD_WALLET");
                    $this->transactions()
                         ->create([
                                      'order_id'             => $orderId,
                                      'wallet_id'            => $this->id,
                                      'cost'                 => $amount,
                                      'transactionstatus_id' => $transactionStatus,
                                      'paymentmethod_id'     => $paymentMethod,
                                      'completed_at'         => $completed_at,
                                  ]);
                }
                $responseText = "SUCCESSFUL";
                $failed = false;
            } else {
                $failed = true;
                $responseText = "CAN_NOT_UPDATE_WALLET";
            }
        } else {
            $failed = true;
            $responseText = "CAN_NOT_WITHDRAW";
        }

        return [
            "result"       => !$failed,
            "responseText" => $responseText,
        ];
    }

    /**
     * Determine if the user can withdraw from this wallet
     *
     * @param  integer $amount
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
        return $this->hasMany("\App\Transaction");
    }

    /**
     * Attempt to move credits from this wallet
     *
     * @param integer $amount
     * @param bool $withoutTransaction
     * @return array
     */
    public function deposit(int $amount, bool $withoutTransaction=false): array
    {
        /**
         * unused variable
        */

        $newBalance = $this->balance + $amount;
        $this->balance = $newBalance;
        $result = $this->update();
        if ($result) {
            if ($amount > 0 && !$withoutTransaction) {
                $completed_at = Carbon::now();
                $transactionStatus = config("constants.TRANSACTION_STATUS_SUCCESSFUL");
                $this->transactions()
                     ->create([
                                  'wallet_id'            => $this->id,
                                  'cost'                 => -$amount,
                                  'transactionstatus_id' => $transactionStatus,
                                  'completed_at'         => $completed_at,
                              ]);
            }
            $responseText = "SUCCESSFUL";
            $failed = false;
        } else {
            $failed = true;
            $responseText = "CAN_NOT_UPDATE_WALLET";
        }

        return [
            "result"       => !$failed,
            "responseText" => $responseText,
        ];
    }

    public function walletType()
    {
        return $this->belongsTo('App\Wallettype', 'wallettype_id', 'id');
    }
}
