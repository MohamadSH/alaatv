<?php

namespace App\Http\Controllers\Web;

use App\Classes\Payment\OnlineGateWay;
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
use Facades\App\Classes\Payment\PaymentVerifier;
use Facades\App\Classes\Payment\ZarinPal;
use Illuminate\Http\{Exceptions\HttpResponseException, JsonResponse, Request, Response};

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
     * redirect the user to online payment page
     * @param Request $request
     * @param string $paymentMethod
     * @param string $device
     * @return JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function paymentRedirect(string $paymentMethod, string $device, Request $request)
    {
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
        $cost = (int) $data['cost'];
        /** @var Transaction $transaction */
        $transaction = $data['transaction'];
        /** @var string $description */
        $description = $data['description'];

        if ($data['statusCode'] != Response::HTTP_OK) {
            $this->sendErrorResponse($data['message'], $data['statusCode']);
        }

        $description .= 'سابت آلاء - ';

        $description = $this->getTransactionDescription($description, $user, $order);

        if ($this->isPayingAnOrder($order)) {
            $order->customerDescription = $request->get('customerDescription');
        }

        if (! $this->canGoToGateWay($cost)) {
            return $this->sendToOfflinePaymentProcess($device, $order);
        }

        $redirectData = OnlineGateWay::getRedirectionData($paymentMethod, $device, $cost, $description, $transaction);

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
     * @param array $inputData
     * @return Refinement
     */
    private function gteRefinementRequestStrategy(array $inputData): Refinement
    {
        if (isset($inputData['transaction_id'])) { // closed order
            return new TransactionRefinement();
        } elseif (isset($inputData['order_id'])) { // closed order
            return new OrderIdRefinement();
        } elseif (isset($inputData['walletId']) && isset($inputData['walletChargingAmount'])) { // Charging Wallet
            return new ChargingWalletRefinement();
        } else { // open order
            return new OpenOrderRefinement();
        }
    }

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
        return PaymentVerifier::verify($paymentMethod, $device, $request);
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
     * @param string $msg
     * @param int $statusCode
     * @return JsonResponse
     */
    private function sendErrorResponse(string $msg, int $statusCode): JsonResponse
    {
        $resp = response()->json(['message' => $msg], $statusCode);
        throw new HttpResponseException($resp);
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
