<?php

namespace App\Repositories;

use App\Classes\Util\Boolean;
use App\Transaction;
use Carbon\Carbon;

class TransactionRepo
{
    /**
     * @param string $authority
     * @param int    $transactionId
     * @param        $gatewayId
     * @param string $description
     *
     * @param string $device
     *
     * @return bool
     */
    public static function setAuthorityForTransaction(string $authority, int $transactionId, $gatewayId, string $description, string $device): Boolean
    {
        $deviceMap = [
            'web'     => 1,
            'android' => 2,
            'ios'     => 3,
        ];

        $data = [
            'destinationBankAccount_id' => 1,
            'authority'                 => $authority,
            'transactiongateway_id'     => $gatewayId,
            'paymentmethod_id'          => config('constants.PAYMENT_METHOD_ONLINE'),
            'description'               => $description,
            'device_id'                 => $deviceMap[$device],
        ];

        return boolean(static::modify($data, $transactionId));
    }

    public static function modify($data, $transactionId)
    {
        $transaction = Transaction::findOrFail($transactionId);
        $transaction->fill($data);
        $props = [
            'referenceNumber',
            'traceNumber',
            'transactionID',
            'authority',
            'paycheckNumber',
            'managerComment',
            'paymentmethod_id',
        ];

        foreach ($props as $prop) {
            if (strlen($transaction->$prop) == 0) {
                $transaction->$prop = null;
            }
        }

        self::setTimestamp($data, "deadline_at", $transaction);
        self::setTimestamp($data, "completed_at", $transaction);

        return $transaction->update();
    }

    /**
     * @param          $data
     * @param string   $column
     * @param          $transaction
     *
     * @return mixed
     */
    private static function setTimestamp($data, string $column, $transaction)
    {
        if (isset($data[$column]) && strlen($data[$column]) > 0) {
            $transaction->$column = Carbon::parse($data[$column])
                ->format('Y-m-d H:i:s');
        }
    }

    public static function getTransactionByAuthority($authority)
    {
        return nullable(Transaction::where('authority', $authority)->first());
    }

    /**
     * @param Transaction $transaction
     * @param string      $refId
     * @param string|null $cardPanMask
     */
    public static function handleTransactionStatus(Transaction $transaction, string $refId, string $cardPanMask = null)
    {
        $user          = optional($transaction->order)->user;
        $bankAccountId = null;
        if (!is_null($cardPanMask) && !is_null($user)) {
            $parameters    = ['user_id' => $user->id, 'cardNumber' => $cardPanMask];
            $bankAccountId = BankaccountRepo::firstOrCreateBankAccount($parameters)->id;
        }

        self::changeTransactionStatusToSuccessful($transaction->id, $refId, $bankAccountId);
    }

    /**
     * @param            $id
     * @param string     $transactionID
     * @param int|null   $bankAccountId
     */
    private static function changeTransactionStatusToSuccessful($id, string $transactionID, int $bankAccountId = null)
    {
        static::modify([
            'completed_at'              => Carbon::now('Asia/Tehran'),
            'transactionID'             => $transactionID,
            'destinationBankAccount_id' => $bankAccountId,
            'transactionstatus_id'      => config('constants.TRANSACTION_STATUS_SUCCESSFUL'),
        ], (int)$id);
    }

    public static function createBasicTransaction(int $orderId, $cost, $comment): ?Transaction
    {
        return Transaction::create([
            'order_id'             => $orderId,
            'cost'                 => $cost,
            'transactionstatus_id' => config('constants.TRANSACTION_STATUS_ORGANIZATIONAL_UNPAID'),
            'managerComment'       => $comment,
        ]);
    }
}
