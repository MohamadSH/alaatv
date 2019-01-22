<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 1/21/2019
 * Time: 1:34 PM
 */

namespace App\Classes\Payment\GateWay;

use App\Bon;
use App\Http\Controllers\TransactionController;
use App\Order;
use Carbon\Carbon;
use App\Transaction;

abstract class GateWayAbstract
{
    /**
     * @var string $description
     */
    protected $description;

    /**
     * @var string $device
     */
    protected $device;

    /**
     * @var string $callbackUrl
     */
    protected $callbackUrl;

    /**
     * @var Transaction $transaction
     */
    protected $transaction;

    /**
     * @var TransactionController $transactionController
     */
    protected $transactionController;

    /**
     * @var Order $order
     */
    protected $order;

    /**
     * @var array $request
     */
    protected $callbackData;

    /**
     * @var array $result
     */
    protected $result;

    public function __construct()
    {
        $this->description = '';
    }

    protected function givesOrderBonsToUser()
    {
        $bonName = config('constants.BON1');
        $bon = Bon::ofName($bonName)->first();

        if (isset($bon)) {
            list($givenBonNumber, $failedBonNumber) = $this->order->giveUserBons($bonName);

            if ($givenBonNumber == 0)
                if ($failedBonNumber > 0)
                    $this->result = array_add($this->result, 'saveBon', -1);
                else
                    $this->result = array_add($this->result, 'saveBon', 0);
            else
                $this->result = array_add($this->result, 'saveBon', $givenBonNumber);

            $bonDisplayName = $bon->displayName;
            $this->result = array_add($this->result, 'bonName', $bonDisplayName);
        }
    }

    protected function updateOrderPaymentStatus()
    {
        $paymentstatus_id = null;
        if ((int)$this->order->totalPaidCost() < (int)$this->order->totalCost())
            $paymentstatus_id = config('constants.PAYMENT_STATUS_INDEBTED');
        else
            $paymentstatus_id = config('constants.PAYMENT_STATUS_PAID');
        $this->order->close($paymentstatus_id);

        //ToDo : use updateWithoutTimestamp
        $this->order->timestamps = false;
        $orderUpdateStatus = $this->order->update();
        $this->order->timestamps = true;

        if ($orderUpdateStatus)
            $this->result = array_add($this->result, 'saveOrder', 1);
        else
            $this->result = array_add($this->result, 'saveOrder', 0);
    }

    /**
     * @param string $transactionID
     * @param int|null $bankAccountId
     */
    protected function changeTransactionStatusToSuccessful(string $transactionID, int $bankAccountId=null): void
    {
        $data['completed_at'] = Carbon::now();
        $data['transactionID'] = $transactionID;
        $data['destinationBankAccount_id'] = $bankAccountId;
        $data['transactionstatus_id'] = config("constants.TRANSACTION_STATUS_SUCCESSFUL");
        $this->transactionController->modify($this->transaction, $data);
    }

    public function redirect(array $data) {
        $this->loadForRedirect($data);
    }

    public function verify(array $data) {
        $this->loadForVerify($data);
    }

    /**
     * @param array $data
     * @return $this
     */
    public function loadForRedirect(array $data) {
        $this->setDescription($data['description'])
            ->setTransaction($data['transaction'])
            ->setCallbackUrl($data['device']);
        return $this;
    }

    public function loadForVerify(array $data) {
        $this->setRequest($data['request'])
            ->setResult($data['result']);
        return $this;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description) {
        $this->description = $description;
        return $this;
    }

    /**
     * @param Transaction $transaction
     * @return $this
     */
    public function setTransaction(Transaction $transaction) {
        $this->transaction = $transaction;
        return $this;
    }

    /**
     * @param string $device
     * @return $this
     */
    public function setCallbackUrl(string $device) {
        $this->device = $device;
        $this->callbackUrl = action('OnlinePaymentController@verifyPayment', ['paymentMethod' => 'zarinpal', 'device' => $this->device]);
        return $this;
    }

    /**
     * @param array $callbackData
     * @return $this
     */
    public function setRequest(array $callbackData) {
        $this->callbackData = $callbackData;
        return $this;
    }

    /**
     * @param array $result
     * @return $this
     */
    public function setResult(array $result) {
        $this->result = $result;
        return $this;
    }
}