<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 1/8/2019
 * Time: 1:17 PM
 */

namespace App\Classes\Payment\RefinementRequest;

use App\Coupon;
use App\Http\Controllers\TransactionController;
use App\Http\Requests\InsertTransactionRequest;
use App\Order;
use App\Transactiongateway;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class RefinementClass
{
    public $request;
    public $statusCode;
    public $message;
    public $user;
    public $order;
    public $cost;
    public $donateCost;
    public $transaction;
    protected $unpaidTransactions;


    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->donateCost = 0;
        $this->statusCode = Response::HTTP_BAD_REQUEST;
        $this->message = '';
    }

    /**
     * @return array
     */
    public function getData()
    {
        return [
            'statusCode' => $this->statusCode,
            'message' => $this->message,
            'user' => $this->user,
            'order' => $this->order,
            'cost' => $this->cost,
            'donateCost' => $this->donateCost,
            'transaction' => $this->transaction,
        ];
    }

    /**
     * @param Order $order
     * @return array
     */
    protected function getOrderCost(Order $order): array
    {
        $order = $this->handleCoupon($order);
        $order->refreshCost();
        $cost = $order->totalCost() - $order->totalPaidCost();
        return array($order, $cost);
    }

    /**
     * @param Order $order
     * @return Order
     */
    protected function handleCoupon(Order $order): Order
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
    protected function getTransaction()
    {
        $result = null;
        $zarinGate = Transactiongateway::where('name', 'zarinpal')->first();
        $this->unpaidTransactions = $this->getUnpaidTransactions();
        if ($this->unpaidTransactions->isNotEmpty()) {
            $transaction = $this->unpaidTransactions->first();
            $result['statusCode'] = Response::HTTP_OK;
            $result['message'] = '';
            $result['transaction'] = $transaction;
        } else {
            $transactionController = new TransactionController();
            $request = new InsertTransactionRequest();
            $request->offsetSet("order_id", $this->order->id);
            $request->offsetSet("cost", $this->cost);
            $request->offsetSet("transactiongateway_id", $zarinGate->id);
            $request->offsetSet("transactionstatus_id", Config::get("constants.TRANSACTION_STATUS_TRANSFERRED_TO_PAY"));
            $request->offsetSet("destinationBankAccount_id", 1);
            $request->offsetSet("paymentmethod_id", Config::get("constants.PAYMENT_METHOD_ONLINE"));
            $request->offsetSet("gateway", true);
            $result = $transactionController->storeTransaction($request);
        }
        return $result;
    }

    /**
     * @return mixed
     */
    protected function getUnpaidTransactions()
    {
        $unpaidTransactions = $this->order->unpaidTransactions->where("cost", $this->cost);
        return $unpaidTransactions;
    }
}