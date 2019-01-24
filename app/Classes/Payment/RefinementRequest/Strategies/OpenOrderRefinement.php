<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 1/8/2019
 * Time: 1:29 PM
 */

namespace App\Classes\Payment\RefinementRequest\Strategies;

use App\Order;
use Illuminate\Http\Response;
use App\Classes\Payment\RefinementRequest\{Refinement, RefinementInterface};

class OpenOrderRefinement extends Refinement
{

    /**
     * @return Refinement
     */
    function loadData(): Refinement
    {
        if($this->statusCode!=Response::HTTP_OK) {
            return $this;
        }
        $openOrder = $this->getOpenOrder();
        $openOrder->load('orderproducts');
        if ($openOrder->orderproducts->isNotEmpty()) {
            $this->order = $openOrder;
            $this->getOrderCost();
            $this->donateCost = $this->order->getDonateCost();
            if($this->canDeductFromWallet()) {
                $this->payByWallet();
            }
            $result = $this->getNewTransaction();
            $this->statusCode = $result['statusCode'];
            $this->message = $result['message'];
            $this->transaction = $result['transaction'];
            $this->statusCode = Response::HTTP_OK;
        } else {
            $this->message = 'سبد خرید شما خالیست';
            $this->statusCode = Response::HTTP_BAD_REQUEST;
        }
        return $this;
    }

    /**
     * @return Order
     */
    private function getOpenOrder(): Order
    {
        return $this->firstOrCreateOpenOrder($this->user);
    }
}