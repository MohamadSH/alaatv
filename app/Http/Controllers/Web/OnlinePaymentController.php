<?php

namespace App\Http\Controllers\Web;

use App\Bankaccount;
use App\Classes\Payment\RefinementRequest\Refinement;
use App\Classes\Payment\RefinementRequest\RefinementLauncher;
use App\Classes\Payment\RefinementRequest\Strategies\{ChargingWalletRefinement, OpenOrderRefinement, OrderIdRefinement, TransactionRefinement};
use App\Http\Controllers\Controller;
use App\Order;
use App\Traits\HandleOrderPayment;
use App\Traits\OrderCommon;
use App\Traits\ZarinpalGateway;
use App\Transaction;
use App\User;
use Carbon\Carbon;
use Facades\App\Classes\Payment\ZarinPal;
use Illuminate\Http\{Exceptions\HttpResponseException, JsonResponse, Request, Response};
use Illuminate\Support\Facades\Cache;
use Zarinpal\Zarinpal as ZarinpalComposer;

class OnlinePaymentController extends Controller
{
    use OrderCommon;
    use ZarinpalGateway;
    use HandleOrderPayment;

    /**
     * @var OrderController
     */
    private $orderController;

    /**
     * @var TransactionController
     */
    private $transactionController;

    public function __construct(OrderController $orderController, TransactionController $transactionController)
    {
        $this->orderController = $orderController;
        $this->transactionController = $transactionController;
    }

    /**********************************************************
     * Redirect
     ***********************************************************/

    /**
     * @param Request $request
     * @param string $paymentMethod
     * @param string $device
     * @return JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function paymentRedirect(string $paymentMethod, string $device, Request $request)
    {
        //ToDo: Should remove after adding unit test
        /*$request->offsetSet('order_id', 137);*/ /*$request->offsetSet('transaction_id', 65);*/ /*$request->offsetSet('payByWallet', true);*/

        /*$request->offsetSet('walletId', 1);*/
        /*$request->offsetSet('walletChargingAmount', 50000);*/

        $inputData = $request->all();
        $inputData['transactionController'] = $this->transactionController;
        $inputData['user'] = $request->user();

        $refinementLauncher = new RefinementLauncher($this->gteRefinementRequestStrategy($inputData));
        $data = $refinementLauncher->getData($inputData);

        /** @var User $user */
        $user = $data['user'];
        /** @var Order $order */
        $order = $data['order'];
        /** @var int $cost */
        $cost = (int)$data['cost'];
        /** @var Transaction $transaction */
        $transaction = $data['transaction'];
        /** @var string $description */
        $description = $data['description'];

        if ($data['statusCode'] != Response::HTTP_OK) {
            return $this->sendErrorResponse($data['message'], Response::HTTP_OK);
        }

        $description .= 'سابت آلاء - ';

        $description = $this->getTransactionDescription($description, $user, $order);

        if ($this->isPayingAnOrder($order)) {
            $this->setCustomerDescriptionForOrder($request, $order);
        }

        if (! $this->canGoToGateWay($cost)) {
            return $this->sendToOfflinePaymentProcess($device, $order);
        }
        //////////////zarin pal
        $redirectData = ZarinPal::interactWithZarinPal($paymentMethod, $device, $cost, $description, $transaction);
        //////////////zarin pal
        return view("order.checkout.gatewayRedirect", compact('redirectData'));
    }

    /**
     * @param int $cost
     * @return bool
     */
    private function canGoToGateWay(int $cost)
    {
        return ($cost > 0);
    }

    /**
     * @param Request $request
     * @param Order $order
     */
    private function setCustomerDescriptionForOrder(Request $request, Order $order): void
    {
        $order->customerDescription = $request->get('customerDescription');
    }

    /**
     * @param array $inputData
     * @return Refinement
     */
    private function gteRefinementRequestStrategy(array $inputData): Refinement
    {
        if (isset($inputData['transaction_id'])) { // closed order
            return new TransactionRefinement();
        } else {
            if (isset($inputData['order_id'])) { // closed order
                return new OrderIdRefinement();
            } else {
                if (isset($inputData['walletId']) && isset($inputData['walletChargingAmount'])) { // Charging Wallet
                    return new ChargingWalletRefinement();
                } else { // open order
                    return new OpenOrderRefinement();
                }
            }
        }
    }

    /**********************************************************
     * VerifyPayment
     ***********************************************************/

    /**
     * Verify customer online payment after coming back from payment gateway
     *
     * @param string $paymentMethod
     * @param string $device
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function verifyPayment(string $paymentMethod, string $device, Request $request)
    {
        $paymentData = $request->all();

        $transaction = Transaction::authority($paymentData["Authority"])->first();

        if (! isset($transaction)) {
            return response()->json([
                'error' => 'تراکنشی متناظر با شماره تراکنش ارسالی یافت نشد.',
            ], Response::HTTP_BAD_REQUEST);
        }

        $gatewayResult = $this->buildZarinpalGateway($paymentMethod);
        if (isset($gatewayResult['error'])) {
            return response()->json([
                'message' => 'درگاه مورد نظر یافت نشد',
            ], Response::HTTP_BAD_REQUEST);
        } else {
            /** @var ZarinpalComposer $gateway */
            $gateway = $gatewayResult['gatewayComposer'];
        }

        $verifyResult = [];

        $amount = $this->setDataForGatewayVerify($paymentMethod, $transaction);
        $gatewayVerify = $this->verify($gateway, $amount, $paymentData);
        $verifyResult['zarinpalVerifyResult'] = $gatewayVerify;

        if (isset($transaction->order_id)) {
            $transaction->order->detachUnusedCoupon();
            if ($gatewayVerify['status']) {
                $this->handleTransactionStatus($transaction, $gatewayVerify['data']['RefID'], $gatewayVerify['data']['cardPanMask']);
                $verifyResult['OrderSuccessPaymentResult'] = $this->handleOrderSuccessPayment($transaction->order);
            } else {
                $verifyResult['OrderCanceledPaymentResult'] = $this->handleOrderCanceledPayment($transaction->order);
                $transaction->transactionstatus_id = config('constants.TRANSACTION_STATUS_UNSUCCESSFUL');
                $transaction->update();
            }
        } else {
            if (isset($transaction->wallet_id)) {
                if ($gatewayVerify['status']) {
                    $this->handleWalletChargingSuccessPayment($gatewayVerify['data']['RefID'], $transaction, $gatewayVerify['data']['cardPanMask']);
                } else {
                    $this->handleWalletChargingCanceledPayment($transaction);
                }
            }
        }

//        if ($result['status'] && isset($result['data']['order'])) {
//            /** @var Order $order */
//            $order = $result['data']['order'];
//            optional($order->user)->notify(new InvoicePaid($order));
//        }

        Cache::tags('bon')->flush();

        $request->session()->flash('verifyResult', $verifyResult);

        return redirect(action('Web\OnlinePaymentController@showPaymentStatus', [
            'status' => ($gatewayVerify['status']) ? 'successful' : 'failed',
            'paymentMethod' => $paymentMethod,
            'device' => $device,
        ]));
    }

    /**
     * @param \App\Transaction $transaction
     * @param string $refId
     * @param string|null $cardPanMask
     */
    private function handleTransactionStatus(Transaction $transaction, string $refId, string $cardPanMask = null): void
    {
        $bankAccountId = null;

        if (isset($cardPanMask)) {
            $userId = optional($transaction->order)->user;
            $bankAccount = Bankaccount::firstOrCreate([
                'accountNumber' => $cardPanMask,
                'user_id' => $userId,
            ]);
            $bankAccountId = $bankAccount->id;
        }

        $this->changeTransactionStatusToSuccessful($refId, $transaction, $bankAccountId);
    }

    /**
     * @param string $refId
     * @param Transaction $transaction
     * @param string|null $cardPanMask
     */
    private function handleWalletChargingSuccessPayment(string $refId, Transaction $transaction, string $cardPanMask = null): void
    {
        $bankAccountId = null;

        if (isset($cardPanMask)) {
            $bankAccount = Bankaccount::firstOrCreate(['accountNumber' => $cardPanMask]);
            $bankAccountId = $bankAccount->id;
        }

        $this->changeTransactionStatusToSuccessful($refId, $transaction, $bankAccountId);

        $transaction->wallet->deposit($transaction->cost * (-1), true);
    }

    /**
     * @param Transaction $transaction
     */
    private function handleWalletChargingCanceledPayment(Transaction $transaction): void
    {
        $transaction->transactionstatus_id = config('constants.TRANSACTION_STATUS_UNSUCCESSFUL');
        $transaction->update();
    }

    /**
     * @param string $transactionID
     * @param Transaction $transaction
     * @param int|null $bankAccountId
     */
    private function changeTransactionStatusToSuccessful(string $transactionID, Transaction $transaction, int $bankAccountId = null): void
    {
        $data['completed_at'] = Carbon::now();
        $data['transactionID'] = $transactionID;
        $data['destinationBankAccount_id'] = $bankAccountId;
        $data['transactionstatus_id'] = config("constants.TRANSACTION_STATUS_SUCCESSFUL");
        $this->transactionController->modify($transaction, $data);
    }

    /**
     * @param string $paymentMethod
     * @param Transaction $transaction
     * @return int
     */
    private function setDataForGatewayVerify(string $paymentMethod, Transaction $transaction): int
    {
        switch ($paymentMethod) {
            case 'zarinpal':
                $amount = isset($transaction->wallet_id) ? ($transaction->cost * -1) : $transaction->cost;
                break;
            default:
                // zarinpal
                $amount = isset($transaction->wallet_id) ? ($transaction->cost * -1) : $transaction->cost;
        }

        return $amount;
    }

    /**
     * @param string $status
     * @param string $paymentMethod
     * @param string $device
     * @param Request $request
     * @return void
     */
    public function showPaymentStatus(string $status, string $paymentMethod, string $device, Request $request)
    {
        $result = $request->session()->pull('verifyResult');

        if ($result != null) {
            return view("order.checkout.verification", compact('status', 'paymentMethod', 'device', 'result'));
        } else {
            return redirect()->action('Web\UserController@userOrders');
        }
    }

    /**
     * @param string $str
     * @param int $s1
     * @return JsonResponse
     */
    private function sendErrorResponse(string $str, int $s1): JsonResponse
    {
        return response()->json(['message' => $str], $s1);
    }

    /**
     * @param Order $order
     * @return bool
     */
    private function isPayingAnOrder($order): bool
    {
        return isset($order);
    }

    /**
     * @param string $device
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    private function sendToOfflinePaymentProcess(string $device, Order $order)
    {
        return redirect(action('Web\OfflinePaymentController@verifyPayment', [
            'device' => $device,
            'paymentMethod' => 'wallet',
            'coi' => (isset($order) ? $order->id : null),
        ]));
    }
}
