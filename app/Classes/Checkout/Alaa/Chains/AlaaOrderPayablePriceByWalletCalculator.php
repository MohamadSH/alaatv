<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 12/20/2018
 * Time: 12:31 PM
 */

namespace App\Classes\Checkout\Alaa\Chains;

use App\Classes\Abstracts\Checkout\OrderPayablePriceByWalletCalculator;
use App\Order;

class AlaaOrderPayablePriceByWalletCalculator extends OrderPayablePriceByWalletCalculator
{
    protected function calculateAmountPaidByWallet(Order $order, $finalPrice): int
    {
        $donateCost = $order->donate_amount;

        $payableByWallet = $finalPrice - $donateCost;

        return $payableByWallet;
    }
}
