<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Transaction;
use App\Bankaccount;

class TransactionRepo
{
    /**
     * @param string $authority
     * @param $transactionId
     * @param string $description
     *
     * @return \App\Classes\Util\Boolean
     */
    public static function setAuthorityForTransaction(string $authority, $transactionId, string $description): \App\Classes\Util\Boolean
    {
        $data = [
            'destinationBankAccount_id' => 1,
            'authority' => $authority,
            'transactiongateway_id' => 1,
            'paymentmethod_id' => config('constants.PAYMENT_METHOD_ONLINE'),
            'description' => $description,
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
     * @param $data
     * @param string $column
     * @param $transaction
     * @return mixed
     */
    private static function setTimestamp($data, string $column, $transaction)
    {
        if (isset($data[$column]) && strlen($data[$column]) > 0) {
            $transaction->$column = Carbon::parse($data[$column])->addDay()->format('Y-m-d');
        }
    }

    public static function getTransactionByAuthority($authority)
    {
        return nullable(Transaction::authority($authority)->first());
    }

    /**
     * @param \App\Transaction $transaction
     * @param string $refId
     * @param string|null $cardPanMask
     */
    public static function handleTransactionStatus(Transaction $transaction, string $refId, string $cardPanMask = null)
    {
        $bankAccountId = null;

        if (! is_null($cardPanMask)) {
            $account = [
                'accountNumber' => $cardPanMask,
                'user_id' => optional($transaction->order)->user->id,
            ];

            $bankAccountId = Bankaccount::firstOrCreate($account)->id;
        }

        self::changeTransactionStatusToSuccessful($transaction->id, $refId, $bankAccountId);
    }

    /**
     * @param $id
     * @param string $transactionID
     * @param int|null $bankAccountId
     */
    private static function changeTransactionStatusToSuccessful($id, string $transactionID, int $bankAccountId = null)
    {
        $data = [
        'completed_at' => Carbon::now(),
        'transactionID' => $transactionID,
        'destinationBankAccount_id' => $bankAccountId,
        'transactionstatus_id' => config("constants.TRANSACTION_STATUS_SUCCESSFUL"),
        ];

        static::modify($data,(int) $id);
    }
}