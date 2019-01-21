<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 1/21/2019
 * Time: 1:31 PM
 */

namespace App\Classes\Payment\GateWay\Zarinpal;

use App\Transaction;
use App\Transactiongateway;
use Illuminate\Http\{Request, Response};
use Zarinpal\Zarinpal as ZarinpalComposer;
use App\Http\Controllers\TransactionController;
use App\Classes\Payment\GateWay\GateWayAbstract;

class Zarinpal extends GateWayAbstract
{
    private $error;
    private $refId;
    private $status;
    private $authority;
    private $cardPanHash;
    private $merchantNumber;
    private $zarinpalComposer;
    private $transactiongatewayId;

    public function __construct(TransactionController $transactionController)
    {
        parent::__construct();
        $zarinGate = Transactiongateway::where('name', 'zarinpal')->first();
        $this->merchantNumber = $zarinGate->merchantNumber;
        $this->transactiongatewayId = $zarinGate->id;
        $this->zarinpalComposer = new ZarinpalComposer($this->merchantNumber);
        $this->zarinpalComposer->enableSandbox(); // active sandbox mod for test env
        $this->zarinpalComposer->isZarinGate(); // active zarinGate mode
        $this->transactionController = $transactionController;
    }

    /**
     * Making request to ZarinPal gateway
     * must loadForRedirect before
     * @return string
     */
    public function redirect()
    {
        $results = $this->zarinpalComposer->request($this->callbackUrl, (int)$this->transaction->cost, $this->description);

        if (isset($results['Authority']) && strlen($results['Authority']) > 0) {
            $data['gateway'] = $this->zarinpalComposer;
            $data['destinationBankAccount_id'] = 1;
            $data['authority'] = $results['Authority'];
            $data['transactiongateway_id'] = $this->transactiongatewayId;
            $data['paymentmethod_id'] = config('constants.PAYMENT_METHOD_ONLINE');
            $result = $this->transactionController->modify($this->transaction, $data);
            if ($result['statusCode'] == Response::HTTP_OK) {
                $this->zarinpalComposer->redirect();
                return null;
            }
            else {
                return 'مشکل در برقراری ارتباط با درگاه زرین پال';
            }
        } else {
            return $results['error'];
        }
    }

    /**
     * verify ZarinPal callback request
     * must loadForVerify before
     * @return array $this->result
     */
    public function verify(): array
    {
        $this->result['isAdminOrder'] = false;

        $this->init();

        $this->order->detachUnusedCoupon();

        $verifyZarinpalResult = $this->verifyZarinpal();

        if (!isset($verifyZarinpalResult)) {
            $this->result['Status'] = 'error';
            return $this->result;
        }

        if ($this->status === 'success') {
            $this->handleSuccessStatus();
        } else if ($this->status === 'canceled') {
            $this->handleCanceledStatus();
        }

        return $this->result;


//        $newTransaction = true;
//        if (isset($data["authority"])) {
//            $transaction = Transaction::where("authority", $data["authority"])->first();
//            if (isset($transaction)) {
//        if ($transaction->order->user->id != $order->user->id) {
//            $result['statusCode'] = Response::HTTP_FORBIDDEN;
//            $result['message'] = "تراکنشی با این شماره Authority قبلا برای شخص دیگری ثبت شده است";
//            return $result;
//        }
//        if ($data["cost"] != $transaction->cost) {
//            $result['statusCode'] = Response::HTTP_FORBIDDEN;
//            $result['message'] = "مبلغ وارد شده با تراکنش تصدیق نشده ای که یافت شد همخوانی ندارد";
//            return $result;
//        }
//        $zarinGate = Transactiongateway::where('name', 'zarinpal')->first();
//        $merchant = $zarinGate->merchantNumber;
//        $zarinPal = new Zarinpal($merchant);
//        /*$zarinPal->enableSandbox(); // active sandbox mod for test env*/
//        /*$zarinPal->isZarinGate(); // active zarinGate mode*/
//        $result = $zarinPal->verifyWithExtra($transaction->cost, $transaction->authority);
//        if (strcmp($result["Status"], "success") == 0) {
//            $transaction->transactionID = $result["RefID"];
//            $transaction->order_id = $data["order_id"];
//            $transaction->transactionstatus_id = Config::get("constants.TRANSACTION_STATUS_SUCCESSFUL");
//            if ($transaction->update()) {
//                $result['statusCode'] = Response::HTTP_OK;
//                $result['message'] = "تراکنش با موفقیت تصدیق شد و اطلاعات آن ثبت گردید";
//                $result['transaction'] = $transaction;
//                return $result;
//            } else {
//                $result['statusCode'] = Response::HTTP_INTERNAL_SERVER_ERROR;
//                $result['message'] = "خطای پایگاه داده در ثبت تراکنش";
//                return $result;
//            }
//        } else if (strcmp($result["Status"], "verified before") == 0) {
//            $transaction->transactionID = $result["RefID"];
//            $transaction->order_id = $data["order_id"];
//            $transaction->transactionstatus_id = Config::get("constants.TRANSACTION_STATUS_SUCCESSFUL");
//            if ($transaction->update()) {
//                $result['statusCode'] = Response::HTTP_OK;
//                $result['message'] = "این تراکنش قبلا تصدیق شده بود. اطلاعات تراکنش ثبت شد";
//                $result['transaction'] = $transaction;
//                return $result;
//            } else {
//                $result['statusCode'] = Response::HTTP_INTERNAL_SERVER_ERROR;
//                $result['message'] = "خطای پایگاه داده در ثبت تراکنش";
//                return $result;
//            }
//        } else if (strcmp($result["Status"], "error") == 0) {
//            $result['statusCode'] = Response::HTTP_INTERNAL_SERVER_ERROR;
//            $result['message'] = "پاسخ سرویس دهنده خطای " . $result["error"] . " می باشد";
//            return $result;
//        } else {
//            $result['statusCode'] = Response::HTTP_INTERNAL_SERVER_ERROR;
//            $result['message'] = "پاسخ نامعتبر از سرویس دهنده";
//            return $result;
//        }



//        if (!$comesFromAdmin)
//            if ($order->totalPaidCost() >= (int)$order->totalCost()) {
//                $order->paymentstatus_id = config("constants.PAYMENT_STATUS_PAID");
//                $transactionMessage = "تراکنش شما با موفقیت درج شد.مسئولین سایت در اسرع وقت اطلاعات بانکی ثبت شده را بررسی خواهند کرد  و سفارش شما را تایید خواهند نمود. سفارش شما در حال حاضر در وضعیت منتظر تایید می باشد.";
//            } else {
//                $order->paymentstatus_id = config("constants.PAYMENT_STATUS_INDEBTED");
//                $transactionMessage = "تراکنش شما با موفقیت درج شد.مسئولین سایت در اسرع وقت اطلاعات بانکی ثبت شده را بررسی خواهند کرد  و تراکنش شما را تایید خواهند نمود.";
//            }
//        else $transactionMessage = "تراکنش با موفقیت درج شد";
//        $order->timestamps = false;
//        if (!$order->update()) {
//            $result['statusCode'] = Response::HTTP_INTERNAL_SERVER_ERROR;
//            $result['message'] = "خطای پایگاه داده در به روز رسانی سفارش شما";
//            $result['transaction'] = $transaction;
//            return $result;
//        }
//        $order->timestamps = true;


//            }
//        }

    }



    /**
     * @param Request $request
     */
    private function init(): void
    {
        $this->authority = $this->request->get('Authority');
        $this->status = $this->request->get('Status');
        $this->transaction = Transaction::with(['order'])->authority($this->authority)->firstOrFail();
        $this->order = $this->transaction->order;
    }

    /**
     * @return array
     */
    private function verifyZarinpal(): array
    {
        /*$merchant = $this->transaction->transactiongateway->merchantNumber;*/

        /**
         * $result['Status'] going to be 'success', 'error' or 'canceled'
         */
        $result = $this->zarinpalComposer->verify($this->status, $this->transaction->cost, $this->authority);

        $this->error = (strcmp($result['Status'], 'error') == 0)? $result['error'] : null;

        if (isset($result['RefID']) && strcmp($result['Status'], 'success') == 0) {
            $this->refId = $result['RefID'];
            $this->status = 'success';
            $this->cardPanHash = $result['ExtraDetail']['Transaction']['CardPanHash'];
        } else if (strcmp($result['Status'], 'canceled') == 0 ||
            (strcmp($result['Status'], 'error') == 0 && (
                    strcmp($result['error'], '-22') == 0 || //وارد درگاه بانک شده و انصراف زده
                    strcmp($result['error'], '-21') == 0 // قبل از ورود به درگاه بانک در همان صفحه زرین پال انصراف زده
                ))) {
            $this->status = 'canceled';
        } else {
            $this->status = 'canceled';
        }
        return $result;
    }

    private function handleSuccessStatus()
    {
        $this->changeTransactionStatusToSuccessful($this->refId);

        $this->order->closeWalletPendingTransactions();

        $this->updateOrderPaymentStatus();

        /** Attaching user bons for this order */
        $this->givesOrderBonsToUser();

        $this->result['transactionID'] = $this->refId;
        $this->result['sendSMS'] = true;
        $this->result['Status'] = 'success';
    }

    private function handleCanceledStatus()
    {
        $this->result['Status'] = 'canceled';

        $this->order->close(config('constants.PAYMENT_STATUS_UNPAID'), config('constants.ORDER_STATUS_CANCELED'));
        //ToDo : use updateWithoutTimestamp
        $this->order->timestamps = false;
        $this->order->update();
        $this->order->timestamps = true;

        $this->transaction->transactionstatus_id = config('constants.TRANSACTION_STATUS_UNSUCCESSFUL');
        $this->transaction->update();

        $totalWalletRefund = $this->order->refundWalletTransaction();

        if ($totalWalletRefund > 0) {
            $this->result['walletAmount'] = $totalWalletRefund;
            $this->result['walletRefund'] = true;
        }
    }
}