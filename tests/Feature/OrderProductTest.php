<?php

namespace Tests\Feature;

use App\Product;
use App\User;
use App\Wallet;
use App\Userbon;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use App\Traits\OrderCommon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
//use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderProductTest extends TestCase
{
//    use RefreshDatabase;
    use OrderCommon;

    public function testAddToOrder() {

//        $this->resetOrders();
//        $user = User::find(1)->first();

        /** @var User $user */
        $user = factory(User::class)->create();

        $wallet = factory(Wallet::class)->create([
            'wallettype_id' => 1,
            'balance' => 1000,
            'user_id' => $user->id
        ]);
        $produc = factory(Product::class)->create([
            'producttype_id'=>1,
            'attributeset_id'=>3
        ]);


        $orderId = $user->getOpenOrder()->id;

        $data = [
            'order_id' => $orderId,
            'product_id' => $produc->id,
            'products' => [],
            'attribute' => [],
            'extraAttribute' => [],
            'withoutBon' => false
        ];

//        $sampleData = $this->getSampleData('simple1', $user); // simple product
//        $sampleData = $this->getSampleData('simple2', $user);// 270 is gift of 155
//        $sampleData = $this->getSampleData('simple3', $user);// 157 is child of 155 and gift of 155 is 270
//        $sampleData = $this->getSampleData('donate1', $user);// 5000
//        $sampleData = $this->getSampleData('donate2', $user);// custom
//        $sampleData = $this->getSampleData('selectable', $user);
//        $sampleData = $this->getSampleData('configurable', $user);

//        $data = [
//            'order_id' => $sampleData['orderId'],
//            'product_id' => $sampleData['productId'],
//            'products' => $sampleData['data']['products'],
//            'attribute' => $sampleData['data']['attribute'],
//            'extraAttribute' => $sampleData['data']['extraAttribute'],
//            'withoutBon' => false
//        ];





        $response = $this
            ->actingAs($user)
            ->call('POST', 'orderproduct', $data);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'product saved'
            ])
        ;

        $user->forceDelete();
        $produc->forceDelete();

    }

    /**
     * generate sample data for test store orderProduct
     * @param $case
     * @param User $user
     * @return array
     */
    private function getSampleData($case, User $user) {

        $orderId = $user->getOpenOrder()->id;

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
