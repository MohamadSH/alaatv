<?php namespace App\Traits;

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
}
