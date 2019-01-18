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
use Illuminate\Http\{Request, Response};
use App\Http\Controllers\TransactionController;

abstract class Refinement
{
    use OrderCommon;

    /**
     * @var Request
     */
    public $inputData;

    /**
     * @var int
     */
    public $statusCode;

    /**
     * @var string
     */
    public $message;

    /**
     * @var User
     */
    public $user;

    /**
     * @var Order
     */
    public $order;

    /**
     * @var int
     */
    public $cost;

    /**
     * @var int
     */
    public $paidFromWalletCost;

    /**
     * @var int
     */
    public $donateCost;

    /**
     * @var Transaction
     */
    public $transaction;

    /**
     * @var string
     */
    public $description;


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
        $this->transactionController = $this->inputData['transactionController'];
        $this->user = $this->inputData['user'];
        return $this;
    }

    /**
     * @return Refinement
     */
    public function validateData(): Refinement {
        if(!isset($this->user))
            $this->message = 'user not set';

        if(!isset($this->transactionController))
            $this->message = 'transactionController not set';

        $this->statusCode = Response::HTTP_BAD_REQUEST;
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
     * @return array|null
     */
    protected function getNewTransaction()
    {
        $result = null;
        if($this->cost>0) {
            $data['gateway'] = true;
            $data['cost'] = $this->cost;
            $data['order_id'] = $this->order->id;
            $data['destinationBankAccount_id'] = 1;
            $data['paymentmethod_id'] = config("constants.PAYMENT_METHOD_ONLINE");
            $data['transactionstatus_id'] = config("constants.TRANSACTION_STATUS_TRANSFERRED_TO_PAY");
            $result = $this->transactionController->storeTransaction($data);
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
        if ($walletPayResult["result"]) {
            $remainedCost = $walletPayResult["cost"];

            $this->order->close(config("constants.PAYMENT_STATUS_INDEBTED"));
            $this->order->updateWithoutTimestamp();
        }
        $remainedCost = $remainedCost + $this->donateCost;
        $this->cost = $remainedCost;
        $this->paidFromWalletCost = $deductibleCostFromWallet - $remainedCost;
    }
}