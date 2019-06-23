<?php

namespace App\Http\Controllers\Web;

use App\Order;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
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
        
        Cache::tags('bon')->flush();
        Cache::tags('order')->flush();
        Cache::tags('user')->flush();
        Cache::tags('orderproduct')->flush();
        
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
            $orderproducts = $order->products();
            $gtmEec        = [
                'actionField' => [
                    'id'          => $order->id,
                    'affiliation' => $device,
                    'revenue'     => number_format($result['paidPrice'] ?? 1, 2, '.', ''),
                    'tax'         => '0',
                    'shipping'    => '0',
                    'coupon'      => optional($order->coupon)->code ?? '',
                ],
                'products'    => []
            ];
            foreach ($orderproducts as $product) {
                $gtmEec['products'][] = [
                    'id'       => $product->id,
                    'name'     => $product->name,
                    'category' => '-',
                    'variant'  => '-',
                    'brand'    => 'آلاء',
                    'quantity' => 1,
                    'price'    => number_format($product->price['final'] ?? 0, 2, '.', ''),
                ];
            }
        }
        return $gtmEec;
    }
}
