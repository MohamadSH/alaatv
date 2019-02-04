<?php

namespace App\Http\Middleware;

use App\Traits\OrderCommon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\OrderController;

use App\Userbon;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckPermissionForSendOrderId
{
    use OrderCommon;

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
        if (Auth::guard($guard)->check()) {

//            $this->user = $request->user()->load('openOrders');
//            $this->resetOrders();
////
////        $sampleData = $this->getSampleData('simple1', $this->user, $request); // simple product
////        $sampleData = $this->getSampleData('simple2', $this->user, $request);// 270 is gift of 155
////        $sampleData = $this->getSampleData('simple3', $this->user, $request);// 157 is child of 155 and gift of 155 is 270
////        $sampleData = $this->getSampleData('donate1', $this->user, $request);// 5000
////        $sampleData = $this->getSampleData('donate2', $this->user, $request);// custom
////        $sampleData = $this->getSampleData('selectable', $this->user, $request);
//            $sampleData = $this->getSampleData('configurable1111', $this->user, $request);
//            $request->offsetSet('order_id', $sampleData['orderId']);
//            $request->offsetSet('product_id', $sampleData['productId']);
//            $request->offsetSet('products', $sampleData['data']['products']);
//            $request->offsetSet('attribute', $sampleData['data']['attribute']);
//            $request->offsetSet('extraAttribute', $sampleData['data']['extraAttribute']);
//            $request->offsetSet('withoutBon', false);


            if($request->has('order_id')) {
                if(!$this->user->can(config('constants.INSERT_ORDERPRODUCT_ACCESS'))) {
                    return response()->json([
                        'error' => 'Forbidden'
                    ], Response::HTTP_FORBIDDEN);
                }
            } else {
                $openOrder = $request->user()->getOpenOrder();;
                $request->offsetSet('order_id', $openOrder->id);
                $request->offsetSet('openOrder', $openOrder);
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
     * @param User $user
     * @param Request $request
     * @return array
     */
    private function getSampleData($case, User $user, Request &$request) {

        $openOrder = $user->getOpenOrder();

        $orderId = $openOrder->id;

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
            case 'donate1':
                /**
                 * donate product
                 * 5000
                 */
                return [
                    'orderId' => $orderId,
                    'productId' => 180,
                    'data' => [
                        'products' => [],
                        'attribute' => [],
                        'extraAttribute' => []
                    ]
                ];
            case 'donate2':
                /**
                 * donate product
                 * custom
                 */
                return [
                    'orderId' => $orderId,
                    'productId' => 181,
                    'data' => [
                        'products' => [],
                        'attribute' => [],
                        'extraAttribute' => []
                    ]
                ];
            case 'selectable':
                /**
                 * selectable product
                 * 241 children: 247, 248
                 * 247 children: 219, 220, 258
                 * 248 children: 259, 260
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
                 * has bon
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
                    'productId' => 277,
                    'data' => [
                        'products' => [],
                        'attribute' => [],
                        'extraAttribute' => []
                    ]
                ];
        }
    }

    /**
     *reset order and orderProduct and user bons for test store orderProduct
     */
    private function resetOrders() {
        $Userbon = Userbon::findOrFail(6);
        $Userbon->usedNumber = 0;
        $Userbon->userbonstatus_id = 1;
        $Userbon->update();
        DB::table('orders')->delete();
        /*DB::table('orderproducts')->delete();
        DB::table('attributevalue_orderproduct')->delete();*/

        /*dd('OrdersReset Done!');*/
    }

}
