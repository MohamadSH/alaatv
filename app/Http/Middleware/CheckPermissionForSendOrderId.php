<?php

namespace App\Http\Middleware;

use App\Http\Controllers\OrderController;
use App\Userbon;
use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;

class CheckPermissionForSendOrderId
{
    /**
     * @var OrderController
     */
    private $orderController;
    private $user;

    /**
     * OrderCheck constructor.
     * @param Request $request
     * @param OrderController $controller
     */
    public function __construct(Request $request, OrderController $controller)
    {
        $this->orderController = $controller;
        $this->user = $request->user();
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @param null                      $guard
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
//       $this->resetOrders();

        $user = $request->user();

//        $sampleData = $this->getSmapleData('simple1', $user, $request); // simple product
//        $sampleData = $this->getSmapleData('simple2', $user, $request);// 270 is gift of 155
//        $sampleData = $this->getSmapleData('simple3', $user, $request);// 157 is childe of 155 and gift of 155 is 270
//        $sampleData = $this->getSmapleData('selectable', $user, $request);
        $sampleData = $this->getSmapleData('configurable', $user, $request);
//        $request->offsetSet('order_id', $sampleData['orderId']);
        $request->offsetSet('product_id', $sampleData['productId']);
        $request->offsetSet('products', $sampleData['data']['products']);
        $request->offsetSet('attribute', $sampleData['data']['attribute']);
        $request->offsetSet('extraAttribute', $sampleData['data']['extraAttribute']);
        $request->offsetSet('withoutBon', false);

        if (Auth::guard($guard)->check()) {
            if($request->has('order_id')) {
                if(!$this->user->can(config("constants.INSERT_ORDERPRODUCT_ACCESS"))) {
                    return response()->json([
                        'error' => 'Forbidden'
                    ], Response::HTTP_FORBIDDEN);
                }
            } else {
                $request->offsetSet('order_id', $this->user->openOrders()->first()->id);
            }
        } else {
            return response()->json([
                'error' => 'Unauthenticated'
            ], Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }

    /**
     * generate sample data for test store orderProduct
     * @param $case
     * @param $user
     * @param Request $request
     * @return array
     */
    private function getSmapleData($case, $user, Request &$request) {




        $openOrder = $user->openOrders()->get();

        if ($openOrder->isEmpty()) {
            $request->offsetSet("paymentstatus_id", Config::get("constants.PAYMENT_STATUS_UNPAID"));
            $request->offsetSet("orderstatus_id", Config::get("constants.ORDER_STATUS_OPEN"));
            $request->offsetSet("user_id", $user->id);
            $controller = $this->orderController;
            $order = $controller->store($request);
        } else {
            $order = $openOrder->first();
        }
        $orderId = $order->id;

        switch ($case) {
            case 'simple1':
                /**
                 * simple product
                 * without bon
                 * don't have extraAttribute
                 */
                return [
                    'orderId' => $orderId,
                    'productId' => 259,
                    'data' => [
                        'products' => [241, 247],
                        'attribute' => [1,3,9,49,53],
                        'extraAttribute' => [
                            [
                                'id'=>60,
                                'cost'=>600
                            ],
                            [
                                'id'=>21,
                                'cost'=>700
                            ]
                        ]
                    ]
                ];
            case 'simple2':
                /**
                 * simple product
                 * has bon
                 * 270 is gift of 155
                 * don't have extraAttribute
                 */
                return [
                    'orderId' => $orderId,
                    'productId' => 270,
                    'data' => [
                        'products' => [],
                        'attribute' => [],
                        'extraAttribute' => [
                            [
                                'id'=>60,
                                'cost'=>600
                            ],
                            [
                                'id'=>21,
                                'cost'=>700
                            ]
                        ]
                    ]
                ];
            case 'simple3':
                /**
                 * simple product
                 * 157 is child of 155 and gift of 155 is 270
                 * with bon from father
                 */
                return [
                    'orderId' => $orderId,
                    'productId' => 157,
                    'data' => [
                        'products' => [241, 247],
                        'attribute' => [1,3,9,49,53],
                        'extraAttribute' => [
                            [
                                'id'=>60,
                                'cost'=>600
                            ],
                            [
                                'id'=>21,
                                'cost'=>700
                            ]
                        ]
                    ]
                ];
            case 'selectable':
                /**
                 * selectable product
                 * 241 chids: 247, 248
                 * 247 chids: 219, 220, 258
                 * 248 chids: 259, 260
                 * don't have extraAttribute
                 */
                return [
                    'orderId' => $orderId,
                    'productId' => 240,
                    'data' => [
                        'products' => [
//                            241,
//
//                                247,
//                                    219,
//                                    220,
//                                    258,

//                                248,
                                    259,
                                    260
                        ],
                        'attribute' => [1,3,9,49,53],
                        'extraAttribute' => [
                            [
                                'id'=>60,
                                'cost'=>600
                            ],
                            [
                                'id'=>21,
                                'cost'=>700
                            ]
                        ]
                    ]
                ];
            case 'configurable':
                /**
                 * configurable product
                 * gift of 155 is 270
                 * hase bon
                 * configure product with child (156, 157)
                 */
                return [
                    'orderId' => $orderId,
                    'productId' => 155,
                    'data' => [
                        'products' => [241, 247],
                        'attribute' => [1,3,9,49,53], // => 156
                        'extraAttribute' => [
                            [
                                'id'=>60,
                                'cost'=>600
                            ],
                            [
                                'id'=>21,
                                'cost'=>700
                            ]
                        ]
                    ]
                ];
            default:
                /**
                 * simple product
                 * without bon
                 * don't have extraAttribute
                 */
                return [
                    'orderId' => $orderId,
                    'productId' => 259,
                    'data' => [
                        'products' => [241, 247],
                        'attribute' => [1,3,9,49,53],
                        'extraAttribute' => [
                            [
                                'id'=>60,
                                'cost'=>600
                            ],
                            [
                                'id'=>21,
                                'cost'=>700
                            ]
                        ]
                    ]
                ];
        }
    }

    /**
     *reset order and orderProduct and user bons for test store orderProduct
     */
    private function resetOrders() {
        $Userbon = Userbon::findOrFail(1);
        $Userbon->usedNumber = 0;
        $Userbon->userbonstatus_id = 1;
        $Userbon->update();
        DB::table('orders')->delete();
        DB::table('orderproducts')->delete();
        DB::table('attributevalue_orderproduct')->delete();

        dd('OrdersReset Done!');
    }
}
