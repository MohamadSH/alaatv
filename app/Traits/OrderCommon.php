<?php namespace App\Traits;

use App\Order;
use App\Orderproduct;
use App\Product;
use App\Repositories\OrderproductRepo;
use App\User;
use App\Wallet;

trait OrderCommon
{
    /**
     * @param int $orderId
     * @param     $wallets
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

    protected function canPayOrderByWallet(User $user, int $cost)
    {
        $canPayByWallet = false;
        $wallets        =
            $user->wallets->sortByDesc("wallettype_id"); //Chon mikhastim aval az kife poole hedie kam shavad!

        /** @var Wallet $wallet */
        foreach ($wallets as $wallet) {
            if ($cost <= 0) {
                break;
            }

            $amount = $wallet->balance;
            if ($amount <= 0)
                continue;

            if ($cost < $amount) {
                $amount = $cost;
            }

            $canWithDraw = $wallet->canWithdraw($amount);
            if ($canWithDraw) {
                $wallet->pending_to_reduce = $amount;
                if ($wallet->update()) {
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
     * @param Order        $order
     * @param Orderproduct $orderProduct
     * @param Product      $product
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
     * @param Order        $order
     * @param Product      $gift
     * @param Orderproduct $orderproduct
     *
     * @return Orderproduct|null
     */
    public function attachGift(Order $order, Product $gift, Orderproduct $orderproduct): ?Orderproduct
    {
        $giftOrderproduct =
            OrderproductRepo::createGiftOrderproduct($order->id, $gift->id, $gift->calculatePayablePrice()["cost"]);

        if (!isset($giftOrderproduct)) {
            return null;
        }

        $giftOrderproduct->parents()
            ->attach($orderproduct,
                ["relationtype_id" => config("constants.ORDER_PRODUCT_INTERRELATION_PARENT_CHILD")]);

        return $giftOrderproduct;
    }
}
