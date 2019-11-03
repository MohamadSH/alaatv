<?php

namespace App\Http\Controllers\Web;

use App\Order;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class PaymentStatusController extends Controller
{
    /**
     * @param  string   $status
     * @param  string   $paymentMethod
     * @param  string   $device
     * @param  Request  $request
     *
     * @return void
     */
    public function show(string $status, string $paymentMethod, string $device)
    {
        $result = Request::session()->pull('verifyResult');

        $gtmEec = $this->generateGtmEec($device, $result);

        if ($result != null) {
            return view('order.checkout.verification', compact('status', 'paymentMethod', 'device', 'result', 'gtmEec'));
        }


        return redirect()->action('Web\UserController@userOrders');
    }

    /**
     * @param  string  $device
     * @param          $result
     *
     * @return array
     */
    public function generateGtmEec(string $device, $result): array
    {
        $gtmEec = [];
        if (isset($result['orderId'])) {
            $order         = Order::find($result['orderId']);
            $orderproducts = $order->orderproducts;
            $orderproducts->loadMissing('product');

            $gtmEec        = [
                'actionField' => [
                    'id'          => (string)$order->id,
                    'affiliation' => $device,
                    'revenue'     => (string)number_format($result['paidPrice'] ?? 1, 2, '.', ''),
                    'tax'         => '0.00',
                    'shipping'    => '0.00',
                    'coupon'      => (string)optional($order->coupon)->code ?? '',
                ],
                'products'    => []
            ];

            foreach ($orderproducts as $orderproduct) {
                Log::info('ecommerce category: '.$orderproduct->product->category);
                $gtmEec['products'][] = [
                    'id'       => (string)$orderproduct->product->id,
                    'name'     => $orderproduct->product->name,
                    'category' => (isset($orderproduct->product->category))?$orderproduct->product->category:'-',
                    'variant'  => '-',
                    'brand'    => 'آلاء',
                    'quantity' => 1,
                    'price'    => (string)number_format($orderproduct->getSharedCostOfTransaction() ?? 0, 2, '.', ''),
                ];
            }
        }
        return $gtmEec;
    }
}
