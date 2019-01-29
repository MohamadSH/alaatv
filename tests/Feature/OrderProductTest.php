<?php

namespace Tests\Feature;

use App\Http\Controllers\OrderController;
use App\Order;
use App\Traits\OrderCommon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use App\Userbon;
use DB;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderProductTest extends TestCase
{
    use OrderCommon;

    public function testAddToOrder() {

        Session::start();
        $this->resetOrders();
        $user = User::find(1)->first();
        $request = new Request();

//        $sampleData = $this->getSampleData('simple1', $this->user, $request); // simple product
//        $sampleData = $this->getSampleData('simple2', $this->user, $request);// 270 is gift of 155
//        $sampleData = $this->getSampleData('simple3', $this->user, $request);// 157 is child of 155 and gift of 155 is 270
//        $sampleData = $this->getSampleData('donate1', $this->user, $request);// 5000
//        $sampleData = $this->getSampleData('donate2', $this->user, $request);// custom
//        $sampleData = $this->getSampleData('selectable', $this->user, $request);
        $sampleData = $this->getSampleData('configurable', $user);
        $request->offsetSet('order_id', $sampleData['orderId']);
        $request->offsetSet('product_id', $sampleData['productId']);
        $request->offsetSet('products', $sampleData['data']['products']);
        $request->offsetSet('attribute', $sampleData['data']['attribute']);
        $request->offsetSet('extraAttribute', $sampleData['data']['extraAttribute']);
        $request->offsetSet('withoutBon', false);

        $data = [
            'order_id' => $sampleData['orderId'],
            'product_id' => $sampleData['productId'],
            'products' => $sampleData['data']['products'],
            'attribute' => $sampleData['data']['attribute'],
            'extraAttribute' => $sampleData['data']['extraAttribute'],
            'withoutBon' => false
        ];

        Log::debug('before factory');
        $user11 = factory(User::class)->create();

        Log::debug('before actingAs');
        $this->actingAs($user11);
        Log::debug('after actingAs');


        $response = $this
//            ->visit('/')
//            ->see('Hello, '.$user->name);

            ->call('POST', 'orderproduct', $data);

        Log::debug('before assertJson');

        $response
//            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'created' => true,
            ])
        ;

//            ->seeJsonStructure([
//            'orderproducts' => [
//                'id',
//                'order_id',
//                'product_id',
//                'updated_at',
//                'created_ats',
//                'attributevalues',
//                'orderproducttype_id'
//            ]
//        ]);

//        $this->assertEquals(200, $response->status());


    }


    /**
     * generate sample data for test store orderProduct
     * @param $case
     * @param User $user
     * @return array
     */
    private function getSampleData($case, User $user) {

        $orderId = $this->firstOrCreateOpenOrder($user);

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
        /*DB::table('orderproducts')->delete();
        DB::table('attributevalue_orderproduct')->delete();*/

        /*dd('OrdersReset Done!');*/
    }
}
