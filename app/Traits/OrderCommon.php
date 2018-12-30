<?php namespace App\Traits;

use App\Order;
use App\Orderproduct;
use App\Product;
use Illuminate\Support\Facades\Config;

trait OrderCommon
{
    protected function payOrderCostByWallet($user, $order, $cost)
    {
        $walletPaidFlag = false;
        $wallets = $user->wallets->sortByDesc("wallettype_id"); //Chon mikhastim aval az kife poole hedie kam shavad!
        foreach ($wallets as $wallet) {
            if ($cost < 0)
                break;
            $amount = $wallet->balance;
            if ($amount > 0) {
                if ($cost < $amount)
                    $amount = $cost;

                $result = $wallet->withdraw($amount, $order->id);
                if ($result["result"]) {
                    $cost = $cost - $amount;
                    $walletPaidFlag = true;
                }
            }
        }

        return [
            "result" => $walletPaidFlag,
            "cost"   => $cost,
        ];
    }

    /** Attaches a gift to the order of this orderproduct which is related to this orderproduct
     *
     * @param Order $order
     * @param Product $gift
     * @param Orderproduct $orderproduct
     * @return Orderproduct
     */
    public function attachGift(Order $order, Product $gift, Orderproduct $orderproduct): Orderproduct
    {
        $giftOrderproduct = new Orderproduct();
        $giftOrderproduct->orderproducttype_id = Config::get("constants.ORDER_PRODUCT_GIFT");
        $giftOrderproduct->order_id = $order->id;
        $giftOrderproduct->product_id = $gift->id;
        $giftOrderproduct->cost = $gift->calculatePayablePrice()["cost"];
        $giftOrderproduct->discountPercentage = 100;
        $giftOrderproduct->save();

        $giftOrderproduct->parents()
            ->attach($orderproduct, ["relationtype_id" => Config::get("constants.ORDER_PRODUCT_INTERRELATION_PARENT_CHILD")]);
        return $giftOrderproduct;
    }
}