<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 12/17/2018
 * Time: 5:58 PM
 */

namespace App\Classes\Order\OrderProduct;

use App\Product;
use App\Order;
use App\User;
use App\Orderproduct;
use App\Traits\ProductCommon;
use mysql_xdevapi\Collection;

class OrderproductUtility
{
    use ProductCommon;

    protected $orderProdutcs;
    protected $order;
    protected $products;
    protected $data; // extraAttribute, attributes or product ids in array
    protected $user;
    protected $orderstatus;

    public function __construct(User $user, Order $order, $products, $data) {
        $this->order = $order;
        $this->products = $products;
        $this->data = $data;
        $this->user = $user;
        $this->orderstatus = $this->order->orderstatus->id;
    }

    public function store() {

        foreach ($this->products as $key=>$productItem) {

            //ToDo : must consider fonate product and remove that from orderProduct list
//            $donateFlag = false;
//            if (isset($this->orderstatus) && $this->orderstatus == config("constants.ORDER_STATUS_OPEN_DONATE")) {
//                $donateFlag = true;
//            }


            /**
             * check that product exist in OrderProduct list
             */
            $orderHasProduct = false;
            foreach ($this->order->orderproducts as $singleOrderproduct) {
//                if ($donateFlag) {
//                    $singleOrderproduct->delete();
//                } else
//
                if ($productItem->id == $singleOrderproduct->product->id) {
                    $orderHasProduct = true;
                    // can increase amount of orderproduct
                    break;
                }
            }
            if ($orderHasProduct) {
                continue;
            }


            /**
             * store OrderProduct
             */
            $orderproductStoreResult = (new Orderproduct())->store($this->order, $productItem);
            if ($orderproductStoreResult['status']) {

                $orderproduct = $orderproductStoreResult['data'];

                /**
                 * Adding selected extra attributes to the orderproduct
                 */
                $extraAttributes = $this->data['extraAttribute'];
                if (isset($extraAttributes)) {
                    foreach ($extraAttributes as $value) {
                        $myParent = $this->makeParentArray($productItem);
                        $myParent = end($myParent);
                        $attributevalue = $myParent->attributevalues->where("id", $value);
                        if ($attributevalue->isNotEmpty()) {
                            $orderproduct->attributevalues()->attach(
                                $attributevalue->first()->id,
                                ["extraCost" => $attributevalue->first()->pivot->extraCost]
                            );
                        }
                    }
                }


                /**
                 * Obtaining product amount
                 */
                (new Product())->decreaseProductAmountWithValue($productItem, 1);


                //ToDo : must consider cost in another place
//                /**
//                 * Saving orderproduct cost
//                 */
//                $costArray = [];
//
//                if ($this->request->has("cost_bhrk")) {
//                    $costArray["cost"] = $this->request->get("cost_bhrk");
//                } else {
//                    $costArray = $orderproduct->obtainOrderproductCost();
//                }
//                $orderproduct->fillCostValues($costArray);
//
//                $updateFlag = $orderproduct->update();
//                /**
//                 *  end
//                 */


            }
        }
    }

    protected function getSavedOrderProductWithProductModel() {
        $this->orderProdutcs = $this->order->orderproducts()->get();
        $productIds = [];
        foreach ($this->orderProdutcs as $key=>$productItem) {
            $productIds[] = $productItem->product_id;
        }
        $products = Product::whereIn('id', $productIds)->get();

        if(count($this->orderProdutcs) !== count($products)) {
            throw new Exception('OrderProducts is not valid!');
        }
        $productAndOrderProduct = [];
        foreach ($this->orderProdutcs as $orderProdutcItem) {
            foreach ($products as $productItem) {
                if($orderProdutcItem->product_id==$productItem->id) {
                    $productAndOrderProduct[] = [
                        'product' => $productItem,
                        'orderProdutc' => $orderProdutcItem
                    ];
                }
            }
        }
        return $productAndOrderProduct;
    }
}