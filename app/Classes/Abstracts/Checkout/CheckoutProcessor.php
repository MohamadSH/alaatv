<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 11/30/2018
 * Time: 4:08 PM
 */

namespace App\Classes\Abstracts\Checkout;

abstract class CheckoutProcessor
{
    protected $successor;

    /**
     * Set successor
     *
     * @param CheckoutProcessor $successor
     */
    public function setSuccessor(CheckoutProcessor $successor)
    {
        $this->successor = $successor;
    }

    /**
     * Processes the intended request (current Cachier class state)
     *
     * @param Cashier $cashier
     *
     * @return false|string
     */
    abstract public function process(Cashier $cashier);

    /**
     * Calls the next process on cashier
     *
     * @param Cashier $cashier
     *
     * @return false|string
     */
    protected function next(Cashier $cashier)
    {
        if (isset($this->successor)) {
            return $this->successor->process($cashier);
        } else {
            return $cashier->getPrice();
        }
    }
}
