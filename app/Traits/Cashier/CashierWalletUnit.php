<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 12/27/2018
 * Time: 11:39 AM
 */

namespace App\Traits\Cashier;


trait CashierWalletUnit
{
    protected $orderPriceExcludedFromWallet;
    protected $amountPaidByWallet;

    /**
     * @param mixed $orderPriceExcludedFromWallet
     * @return mixed
     */
    public function setOrderPriceExcludedFromWallet($orderPriceExcludedFromWallet)
    {
        $this->orderPriceExcludedFromWallet = $orderPriceExcludedFromWallet;
        return $this;
    }

    /**
     * @param mixed $amountPaidByWallet
     * @return mixed
     */
    public function setAmountPaidByWallet($amountPaidByWallet)
    {
        $this->amountPaidByWallet = $amountPaidByWallet;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrderPriceExcludedFromWallet()
    {
        return $this->orderPriceExcludedFromWallet;
    }

    /**
     * @return mixed
     */
    public function getAmountPaidByWallet()
    {
        return $this->amountPaidByWallet;
    }

}