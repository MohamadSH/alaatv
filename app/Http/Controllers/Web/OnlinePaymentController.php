<?php

namespace App\Http\Controllers\Web;

use App\Classes\Payment\OnlineGateWay;
use App\Classes\Payment\RefinementRequest\Refinement;
use App\Classes\Payment\RefinementRequest\RefinementLauncher;
use App\Classes\Payment\RefinementRequest\Strategies\{ChargingWalletRefinement, OpenOrderRefinement, OrderIdRefinement, TransactionRefinement};
use App\Classes\Payment\Responses;
use App\Classes\Util\Boolean;
use App\Http\Controllers\Controller;
use App\Order;
use App\Repositories\TransactionRepo;
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
        $data = $this->getRefinementData($request);

        /** @var User $user */
        $user = $data['user'];
        /** @var Order $order */
        $order = $data['order'];
        /** @var int $cost */
        $cost = (int) $data['cost'];
        /** @var Transaction $transaction */
        $transaction = $data['transaction'];

        if ($data['statusCode'] != Response::HTTP_OK) {
            $this->sendErrorResponse($data['message'], $data['statusCode']);
        }

        /** @var string $description */
        $description = $this->getTransactionDescription($data['description'], $user->mobile, $order);

        if ($this->isPayingAnOrder($order)) {
            $order->customerDescription = $request->get('customerDescription');
        }

        $this->canNotGoToGateWay($cost)
            ->thenRespondWith([Responses::class, 'sendToOfflinePaymentProcess'], [$device, $order->id]);

        $url = $this->comeBackFromGateWay($paymentMethod, $device);
        $authorityCode = OnlineGateWay::getAuthorityFromGate($url, $cost, $description)
            ->orFailWith([Responses::class, 'noResponseFromBackError']);

        TransactionRepo::setAuthorityForTransaction($authorityCode, $transaction->id, $description)
            ->orRespondWith([Responses::class, 'editTransactionError']);

        $redirectData = OnlineGateWay::getGatewayUrl();

        return view("order.checkout.gatewayRedirect", compact('redirectData'));
    }

    /**
     * @param string $description
     * @param $mobile
     * @param Order|null $order
     *
     * @return string
     */
    private function getTransactionDescription(string $description, $mobile, Order $order = null): string
    {
        $description .= 'سابت آلاء - ';
        $description .= $mobile.' - محصولات: ';

        if (is_null($order)) {
            return $description;
        }

        $order->orderproducts->load('product');

        foreach ($order->orderproducts as $orderProduct) {
            if (isset($orderProduct->product->id)) {
                $description .= $orderProduct->product->name.' , ';
            } else {
                $description .= 'یک محصول نامشخص , ';
            }
        }

        return $description;
    }

    /**
     * @param int $cost
     * @return Boolean
     */
    private function canNotGoToGateWay(int $cost)
    {
        return boolean(!($cost > 0));
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
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    private function getRefinementData(Request $request): array
    {
        $inputData = $request->all();
        $inputData['transactionController'] = $this->transactionController;
        $inputData['user'] = $request->user();

        $refinementLauncher = new RefinementLauncher($this->gteRefinementRequestStrategy($inputData));

        return $refinementLauncher->getData($inputData);
    }

    /**
     * @param string $paymentMethod
     * @param string $device
     * @return string
     */
    private function comeBackFromGateWay(string $paymentMethod, string $device): string
    {
        return action('Web\OnlinePaymentController@verifyPayment', ['paymentMethod' => $paymentMethod, 'device' => $device]);
    }
}
