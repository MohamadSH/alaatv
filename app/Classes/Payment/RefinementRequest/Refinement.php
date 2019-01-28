<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 1/8/2019
 * Time: 1:17 PM
 */

namespace App\Classes\Payment\RefinementRequest;

use App\User;
use App\Order;
use App\Coupon;
use App\Transaction;
use App\Traits\OrderCommon;
use Illuminate\Http\Response;
use App\Http\Controllers\TransactionController;

abstract class Refinement
{
    use OrderCommon;

    /**
     * @var array $inputData
     */
    private $inputData;

    /**
     * @var int $statusCode
     */
    protected $statusCode;

    /**
     * @var string $message
     */
    protected $message;

    /**
     * @var User $user
     */
    protected $user;

    /**
     * @var Order $order
     */
    protected $order;

    /**
     * @var int $cost
     */
    protected $cost;

    /**
     * @var int $paidFromWalletCost
     */
    protected $paidFromWalletCost;

    /**
     * @var int $donateCost
     */
    protected $donateCost;

    /**
     * @var Transaction $transaction
     */
    protected $transaction;

    /**
     * @var string $description
     */
    protected $description;

    /**
     * @var int $walletId
     */
    protected $walletId;

    /**
     * @var int $walletChargingAmount
     */
    protected $walletChargingAmount;

    /**
     * @var TransactionController
     */
    protected $transactionController;

    public function __construct()
    {
        $this->donateCost = 0;
        $this->statusCode = Response::HTTP_OK;
        $this->message = '';
        $this->description = '';
    }

    /**
     * @param array $inputData
     * @return Refinement
     */
    public function setData(array $inputData): Refinement {
        $this->inputData = $inputData;
        $this->transactionController = $this->inputData['transactionController']??null;
        $this->user = $this->inputData['user']??null;
        $this->walletId = $this->inputData['walletId']??null;
        $this->walletChargingAmount = $this->inputData['walletChargingAmount']??null;
        return $this;
    }

    /**
     * @return Refinement
     */
    public function validateData(): Refinement {
        if(!isset($this->user)) {
            $this->message = 'user not set';
            $this->statusCode = Response::HTTP_BAD_REQUEST;
        }
        if(!isset($this->transactionController)) {
            $this->message = 'transactionController not set';
            $this->statusCode = Response::HTTP_BAD_REQUEST;
        }
        return $this;
    }

    /**
     * @return Refinement
     */
    abstract function loadData(): Refinement;

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'statusCode' => $this->statusCode,
            'message' => $this->message,
            'user' => $this->user,
            'order' => $this->order,
            'cost' => $this->cost,
            'donateCost' => $this->donateCost,
            'transaction' => $this->transaction,
            'description' => $this->description,
        ];
    }

    protected function getOrderCost(): void
    {
        $this->validateCoupon();
        $this->order->refreshCost();
        $this->cost = $this->order->totalCost() - $this->order->totalPaidCost();
    }

    protected function validateCoupon(): void
    {
        $couponValidationStatus = optional($this->order->coupon)->validateCoupon();
        if ($couponValidationStatus != Coupon::COUPON_VALIDATION_STATUS_OK && $couponValidationStatus != Coupon::COUPON_VALIDATION_STATUS_USAGE_LIMIT_FINISHED) {
            $this->order->detachCoupon();
            $this->order->fresh();
        }
    }

    /**
     * @param bool $deposit
     * @return array|null
     */
    protected function getNewTransaction($deposit = true)
    {
        $result = null;
        if($this->cost>0) {
            if($deposit) {
                $data['cost'] = $this->cost;
            } else {
                $data['cost'] = ($this->cost*(-1));
            }

            $data['description'] = $this->description;
            $data['order_id'] = (isset($this->order))?$this->order->id:null;
            $data['wallet_id'] = (isset($this->walletId))?$this->walletId:null;
            $data['destinationBankAccount_id'] = 1; // ToDo: Hard Code
            $data['paymentmethod_id'] = config('constants.PAYMENT_METHOD_ONLINE');
            $data['transactionstatus_id'] = config('constants.TRANSACTION_STATUS_TRANSFERRED_TO_PAY');
            $result = $this->transactionController->new($data);
        }
        return $result;
    }

    /**
     * @return bool
     */
    protected function canDeductFromWallet()
    {
        if (isset($this->inputData['payByWallet']) && $this->inputData['payByWallet']==true) {
            return true;
        } else {
            return false;
        }
    }

    protected function payByWallet(): void
    {
        $deductibleCostFromWallet = $this->cost - $this->donateCost;
        $remainedCost = $deductibleCostFromWallet;
        $walletPayResult = $this->payOrderCostByWallet($this->user, $this->order, $deductibleCostFromWallet);
        if ($walletPayResult['result']) {
            $remainedCost = $walletPayResult['cost'];

            $this->order->close(config('constants.PAYMENT_STATUS_INDEBTED'));
            $this->order->updateWithoutTimestamp();
        }
        $remainedCost = $remainedCost + $this->donateCost;
        $this->cost = $remainedCost;
        $this->paidFromWalletCost = $deductibleCostFromWallet - $remainedCost;
    }
}