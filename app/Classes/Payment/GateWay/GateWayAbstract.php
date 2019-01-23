<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 1/21/2019
 * Time: 1:34 PM
 */

namespace App\Classes\Payment\GateWay;

use App\Bon;
use Carbon\Carbon;
use App\Transaction;
use App\Http\Controllers\TransactionController;

abstract class GateWayAbstract
{

    /**
     * @var TransactionController $transactionController
     */
    protected $transactionController;

    /**
     * @var array $result
     */
    protected $result;

    public function __construct()
    {
        $this->result = [
            'status' => true,
            'message' => [],
            'data' => []
        ];
    }

    /**
     * @param Transaction $transaction
     * @param string $callbackUrl
     * @param string|null $description
     * @return array
     */
    abstract public function redirect(Transaction $transaction, string $callbackUrl, string $description = null): array;

    /**
     * @param array $callbackData
     * @return array
     */
    abstract public function verify(array $callbackData): array;

    /**
     * @param Transaction $transaction
     */
    protected function givesOrderBonsToUser(Transaction $transaction): void
    {
        $bonName = config('constants.BON1');
        $bon = Bon::ofName($bonName)->first();

        if (isset($bon)) {
            list($givenBonNumber, $failedBonNumber) = $transaction->order->giveUserBons($bonName);
            if ($givenBonNumber == 0) {
                if ($failedBonNumber > 0) {
                    $this->result['data']['saveBon'] = -1;
                }
                else {
                    $this->result['data']['saveBon'] = 0;
                }
            }
            else {
                $this->result['data']['saveBon'] = $givenBonNumber;
            }

            $bonDisplayName = $bon->displayName;
            $this->result['data']['bonName'] = $bonDisplayName;
        }
    }

    /**
     * @param Transaction $transaction
     */
    protected function updateOrderPaymentStatus(Transaction $transaction): void
    {
        $paymentstatus_id = null;
        if ((int)$transaction->order->totalPaidCost() < (int)$transaction->order->totalCost())
            $paymentstatus_id = config('constants.PAYMENT_STATUS_INDEBTED');
        else
            $paymentstatus_id = config('constants.PAYMENT_STATUS_PAID');
        $transaction->order->close($paymentstatus_id);

        //ToDo : use updateWithoutTimestamp
        $transaction->order->timestamps = false;
        $orderUpdateStatus = $transaction->order->update();
        $transaction->order->timestamps = true;

        if ($orderUpdateStatus) {
            $this->result['data']['saveOrder'] = 1;
        } else {
            $this->result['data']['saveOrder'] = 0;
        }
    }

    /**
     * @param string $transactionID
     * @param Transaction $transaction
     * @param int|null $bankAccountId
     */
    protected function changeTransactionStatusToSuccessful(string $transactionID, Transaction $transaction, int $bankAccountId = null): void
    {
        $data['completed_at'] = Carbon::now();
        $data['transactionID'] = $transactionID;
        $data['destinationBankAccount_id'] = $bankAccountId;
        $data['transactionstatus_id'] = config("constants.TRANSACTION_STATUS_SUCCESSFUL");
        $this->transactionController->modify($transaction, $data);
    }
}