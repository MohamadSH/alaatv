<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 1/8/2019
 * Time: 1:20 PM
 */

namespace App\Classes\Payment\RefinementRequest;


use Illuminate\Http\Request;
use App\Classes\Payment\RefinementRequest\Strategies\TransactionRefinement;
use App\Classes\Payment\RefinementRequest\Strategies\OrderIdRefinement;
use App\Classes\Payment\RefinementRequest\Strategies\OpenOrderRefinement;

class RefinementRequest
{
    private $strategy = NULL;
    private $request = NULL;
    //bookList is not instantiated at construct time
    public function __construct(Request $request) {
        $this->request = $request;
        if($request->has('transaction_id')) { // closed order
            $this->strategy = new TransactionRefinement($this->request);
        } else if($request->has('order_id')) { // closed order
            $this->strategy = new OrderIdRefinement($this->request);
        } else { // open order
            $this->strategy = new OpenOrderRefinement($this->request);
        }
    }

    /**
     * @return array: [statusCode, message, user, order, cost, donateCost, transaction]
     */
    public function getData() {
        return $this->strategy->getData();
    }
}