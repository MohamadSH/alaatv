<?php namespace App\Traits;

use App\Order;
use App\Orderproduct;
use App\Product;
use App\User;
use App\Wallet;

trait OrderCommon
{
    /**
     * this method select exist OpenOrder or create new object and insert that then select all field of new open order
     * but firstOrCreate method in laravel just return inserted values and does not return other fields when create and
     * insert new OpenOrder
     *
     * @param  User  $user
     *
     * @return Order
     */
    public function firstOrCreateOpenOrder(User $user): Order
    {

        $openOrder = $user->openOrders->first();
        if (!isset($openOrder)) {
            $openOrder                   = new Order();
            $openOrder->user_id          = $user->id;
            $openOrder->orderstatus_id   = config('constants.ORDER_STATUS_OPEN');
            $openOrder->paymentstatus_id = config('constants.PAYMENT_STATUS_UNPAID');
            $openOrder->save();
        }

        return $openOrder;
    }

    protected function payOrderCostByWallet($user, $order, $cost)
    {
        $walletPaidFlag = false;
        $wallets        = $user->wallets->sortByDesc("wallettype_id"); //Chon mikhastim aval az kife poole hedie kam shavad!
        /** @var Wallet $wallet */
        foreach ($wallets as $wallet) {
            if ($cost <= 0) {
                break;
            }
            $amount = $wallet->balance;
            if($amount <= 0 )
                continue;

            if ($cost < $amount) {
                $amount = $cost;
            }

            $result = $wallet->withdraw($amount, $order->id);
            if ($result["result"]) {
                $cost           = $cost - $amount;
                $walletPaidFlag = true;
            }
        }

        return [
            "result" => $walletPaidFlag,
            "cost"   => $cost,
        ];
    }

    protected function canPayOrderByWallet(User $user, int $cost)
    {
        $canPayByWallet = false;
        $wallets        = $user->wallets->sortByDesc("wallettype_id"); //Chon mikhastim aval az kife poole hedie kam shavad!

        /** @var Wallet $wallet */
        foreach ($wallets as $wallet) {
            if ($cost <= 0) {
                break;
            }

            $amount = $wallet->balance;
            if($amount <= 0 )
                continue;

            if ($cost < $amount) {
                $amount = $cost;
            }

            $canWithDraw = $wallet->canWithdraw($amount);
            if ($canWithDraw) {
                $wallet->pending_to_reduce = $amount;
                if($wallet->update())
                {
                    $cost           = $cost - $amount;
                    $canPayByWallet = true;
                }
            }
        }

        return [
            "result" => $canPayByWallet,
            "cost"   => $cost,
        ];
    }


    /**
     * @param  Order         $order
     * @param  Orderproduct  $orderProduct
     * @param  Product       $product
     */
    private function applyOrderGifts(Order &$order, Orderproduct $orderProduct, Product $product)
    {
        $giftsOfProduct = $product->getGifts();
        $orderGifts     = $order->giftOrderproducts;
        foreach ($giftsOfProduct as $giftItem) {
            if (!$orderGifts->contains($giftItem)) {
                $this->attachGift($order, $giftItem, $orderProduct);
                $order->giftOrderproducts->push($giftItem);
            }
        }
    }

    /** Attaches a gift to the order of this orderproduct
     *
     * @param  Order         $order
     * @param  Product       $gift
     * @param  Orderproduct  $orderproduct
     *
     * @return Orderproduct
     */
    public function attachGift(Order $order, Product $gift, Orderproduct $orderproduct): Orderproduct
    {
        $giftOrderproduct                      = new Orderproduct();
        $giftOrderproduct->orderproducttype_id = config("constants.ORDER_PRODUCT_GIFT");
        $giftOrderproduct->order_id            = $order->id;
        $giftOrderproduct->product_id          = $gift->id;
        $giftOrderproduct->cost                = $gift->calculatePayablePrice()["cost"];
        $giftOrderproduct->discountPercentage  = 100;
        $giftOrderproduct->save();

        $giftOrderproduct->parents()
            ->attach($orderproduct,
                ["relationtype_id" => config("constants.ORDER_PRODUCT_INTERRELATION_PARENT_CHILD")]);

        return $giftOrderproduct;
    }

    /**
     * @param int $orderId
     * @param $wallets
     */
    public function withdrawWalletPendings(int $orderId, $wallets): void
    {
        /** @var Wallet $wallet */
        foreach ($wallets as $wallet) {
            if ($wallet->balance > 0 && $wallet->pending_to_reduce > 0) {
                $withdrawResult = $wallet->withdraw($wallet->pending_to_reduce, $orderId);
                if ($withdrawResult['result']) {
                    $wallet->update([
                        'pending_to_reduce' => 0,
                    ]);
                }
            }
        }
    }
}
