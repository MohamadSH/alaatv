<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 1/8/2019
 * Time: 1:29 PM
 */

namespace App\Classes\Payment\RefinementRequest\Strategies;

use App\Classes\Payment\RefinementRequest\Refinement;
use App\Order;
use Illuminate\Http\Response;

class OpenOrderRefinement extends Refinement
{
    /**
     * @return Refinement
     */
    function loadData(): Refinement
    {
        if ($this->statusCode != Response::HTTP_OK) {
            return $this;
        }
        $openOrder = $this->getOpenOrder();
        $openOrder->load('orderproducts');
        
        if (!$openOrder->orderproducts->isNotEmpty()) {
            $this->message    = 'سبد خرید شما خالیست';
            $this->statusCode = Response::HTTP_BAD_REQUEST;
            
            return $this;
        }
        
        $this->order = $openOrder;
        $this->orderUniqueId = $openOrder->id;
        $this->getOrderCost();
        $this->donateCost = $this->order->getDonateCost();
        if ($this->canDeductFromWallet()) {
            $this->payByWallet();
        }
        $result = $this->getNewTransaction();
        
        $this->statusCode  = $result['statusCode'];
        $this->message     = $result['message'];
        $this->transaction = $result['transaction'];
        
        return $this;
    }
    
    /**
     * @return Order
     */
    private function getOpenOrder(): Order
    {
        return $this->user->getOpenOrder();
    }
}
