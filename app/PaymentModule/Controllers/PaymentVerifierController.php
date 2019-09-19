<?php

namespace App\PaymentModule\Controllers;

use App\Events\FillTmpShareOfOrder;
use App\Notifications\DownloadNotice;
use App\Order;
use AlaaTV\Gateways\Money;
use App\PaymentModule\Responses;
use App\Notifications\InvoicePaid;
use App\Traits\HandleOrderPayment;
use Illuminate\Routing\Controller;
use AlaaTV\Gateways\PaymentDriver;
use Illuminate\Http\RedirectResponse;
use App\Repositories\TransactionRepo;
use Illuminate\Support\Facades\{Cache, Request};
use AlaaTV\Gateways\Contracts\OnlinePaymentVerificationResponseInterface;

class PaymentVerifierController extends Controller
{
    use HandleOrderPayment;

    /**
     * @param  string  $paymentMethod
     * @param  string  $device
     *
     * @return RedirectResponse
     */
    public function verify(string $paymentMethod, string $device)
    {
        Cache::tags('bon')
            ->flush();
        Cache::tags('order')
            ->flush();
        Cache::tags('orderproduct')
            ->flush();

        $paymentClient = PaymentDriver::select($paymentMethod);
        $authority     = $paymentClient->getAuthorityValue();

        $transaction = TransactionRepo::getTransactionByAuthority($authority)
            ->orFailWith([Responses::class, 'transactionNotFoundError']);

        $money = Money::fromTomans(abs($transaction->cost));
        /**
         * @var OnlinePaymentVerificationResponseInterface $verificationResult
         */
        $verificationResult = $paymentClient->verifyPayment($money, $authority);
        $responseMessages   = $verificationResult->getMessages();

        /** @var Order $myOrder */
        $myOrder = $transaction->order;
        $myOrder->detachUnusedCoupon();
        $is_successful_payment = $verificationResult->isSuccessfulPayment();
        if ($is_successful_payment) {
            TransactionRepo::handleTransactionStatus(
                $transaction,
                $verificationResult->getRefId(),
                $verificationResult->getCardPanMask()
            );
            $this->handleOrderSuccessPayment($myOrder);
            $assetLink          = '
            <a href="'.route('user.asset').'" class="btn m-btn--pill m-btn--air m-btn m-btn--gradient-from-info m-btn--gradient-to-accent animated infinite heartBeat">
                دانلودهای من
            </a>';
            $responseMessages[] = 'برای دانلود محصولاتی که خریده اید به صفحه روبرو بروید: '.$assetLink;
            $responseMessages[] = 'توجه کنید که محصولات پیش خرید شده در تاریخ مقرر شده برای دانلود قرار داده می شوند';

            $myOrder->user->notify(new InvoicePaid($myOrder));
            if($device == 'android') {
                $myOrder->user->notify(new DownloadNotice($myOrder));
            }
        } else {
            $this->handleOrderCanceledPayment($myOrder);
            $this->handleOrderCanceledTransaction($transaction);
            $transaction->update();
            $myOrdersPage       = '
            <a href="'.action('Web\UserController@userOrders').'" class="btn m-btn--pill m-btn--air m-btn m-btn--gradient-from-info m-btn--gradient-to-accent animated infinite heartBeat">
                سفارش های من
            </a>';
            $responseMessages[] = 'یک سفارش پرداخت نشده به لیست سفارش های شما افزوده شده است که می توانید با رفتن به صفحه '.$myOrdersPage.' آن را پرداخت کنید';
        }

        setcookie('cartItems', '', time() - 3600, '/');

        /*
        if (isset($myOrder_id)) {} else { if (isset($transaction->wallet_id)) { if ($result['status']) { $this->handleWalletChargingSuccessPayment($gatewayVerify['RefID'], $transaction, $gatewayVerify['cardPanMask']); } else { $this->handleWalletChargingCanceledPayment($transaction); } } } */

        Request::session()
            ->flash('verifyResult', [
                'messages'    => $responseMessages,
                'cardPanMask' => $verificationResult->getCardPanMask(),
                'RefID'       => $verificationResult->getRefId(),
                'isCanceled'  => $verificationResult->isCanceled(),
                'orderId'     => $myOrder->id,
                'paidPrice'   => $money->tomans(),
            ]);

        event(new FillTmpShareOfOrder($myOrder));
        return redirect()->route('showOnlinePaymentStatus', [
            'status'        => $is_successful_payment ? 'successful' : 'failed',
            'paymentMethod' => $paymentMethod,
            'device'        => $device,
        ]);
    }

    /**
     * @param  Order  $order
     *
     * @return array
     */
    private function handleOrderCanceledPayment(Order $order): void
    {
        if ($order->orderstatus_id == config("constants.ORDER_STATUS_OPEN")) {
            $order->close(config('constants.PAYMENT_STATUS_UNPAID'), config('constants.ORDER_STATUS_CANCELED'));
            $order->update();
        }
        //ToDo : Deprecated
        $order->refundWalletTransaction();
    }

    /**
     * @param $transaction
     */
    private function handleOrderCanceledTransaction($transaction): void
    {
        if ($transaction->transactionstatus_id != config("constants.TRANSACTION_STATUS_UNPAID")) //if it is not the payment for an instalment
        {
            $transaction->transactionstatus_id = config('constants.TRANSACTION_STATUS_UNSUCCESSFUL');
        }
    }

    /*
     * private function handleWalletChargingCanceledPayment(Transaction $transaction)
    {
        $transaction->transactionstatus_id = config('constants.TRANSACTION_STATUS_UNSUCCESSFUL');
        $transaction->update();
    }

    private function handleWalletChargingSuccessPayment(string $refId, Transaction $transaction, string $cardPanMask = null)
    {
        $bankAccountId = null;
        if (isset($cardPanMask)) {
            $bankAccount = Bankaccount::firstOrCreate(['accountNumber' => $cardPanMask]);
            $bankAccountId = $bankAccount->id;
        }
        $this->changeTransactionStatusToSuccessful($refId, $transaction, $bankAccountId);
        $transaction->wallet->deposit($transaction->cost * (-1), true);
    }*/
}
