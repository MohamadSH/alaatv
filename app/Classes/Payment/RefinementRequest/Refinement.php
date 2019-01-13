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
use Illuminate\Http\{Request, Response};
use App\Http\Controllers\TransactionController;

abstract class Refinement
{
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
     * @return $this
     */
    public function setData(array $inputData) {
        $this->inputData = $inputData;
        $this->transactionController = $this->inputData['transactionController'];
        $this->user = $this->inputData['user'];
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
        $data['gateway'] = true;
        $data['cost'] = $this->cost;
        $data['order_id'] = $this->order->id;
        $data['destinationBankAccount_id'] = 1;
        $data['paymentmethod_id'] = config("constants.PAYMENT_METHOD_ONLINE");
        $data['transactionstatus_id'] = config("constants.TRANSACTION_STATUS_TRANSFERRED_TO_PAY");
        $result = $this->transactionController->storeTransaction($data);
        return $result;
    }

    /**
     * @return Refinement
     */
    abstract function loadData(): Refinement;
}