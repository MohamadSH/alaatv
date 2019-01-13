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
    public $request;

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

    public function __construct(TransactionController $transactionController)
    {
        $this->donateCost = 0;
        $this->statusCode = Response::HTTP_BAD_REQUEST;
        $this->message = '';
        $this->description = '';
        $this->transactionController = $transactionController;
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function setRequest(Request $request) {
        $this->request = $request;
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

    /**
     * @param Order $order
     * @return array
     */
    protected function getOrderCost(Order $order): array
    {
        $order = $this->validateCoupon($order);
        $order->refreshCost();
        $cost = $order->totalCost() - $order->totalPaidCost();
        return array($order, $cost);
    }

    /**
     * @param Order $order
     * @return Order
     */
    protected function validateCoupon(Order $order): Order
    {
        $couponValidationStatus = optional($order->coupon)->validateCoupon();
        if ($couponValidationStatus != Coupon::COUPON_VALIDATION_STATUS_OK && $couponValidationStatus != Coupon::COUPON_VALIDATION_STATUS_USAGE_LIMIT_FINISHED) {
            $order->detachCoupon();
            $order = $order->fresh();
        }
        return $order;
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
}