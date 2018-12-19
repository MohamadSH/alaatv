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

    private $orderProdutcs;
    private $order;
    private $products;
    private $data; // extraAttribute, attributes or product ids in array
    private $user;
    private $orderstatus;

    public function __construct(User $user, Order $order, $products, $data) {
        $this->order = $order;
        $this->products = $products;
        $this->data = $data;
        $this->user = $user;
        $this->orderstatus = $this->order->orderstatus->id;

//        $this->orderProdutcs = $this->order->orderproducts();
    }

    public function store() {

        $hasPishtazExtraValue = false;

        foreach ($this->products as $key=>$productItem) {

            $donateFlag = false;
            if (isset($this->orderstatus) && $this->orderstatus == config("constants.ORDER_STATUS_OPEN_DONATE")) {
                $donateFlag = true;
            }

//            if ($this->order->orderproducts->isNotEmpty()) {
                $orderHasProduct = false;
                foreach ($this->order->orderproducts as $singleOrderproduct) {
                    if ($donateFlag) {
                        $singleOrderproduct->delete();
                    } else if ($productItem->id == $singleOrderproduct->product->id) {
                        $orderHasProduct = true;
                        // can increase amount of orderproduct
                        break;
                    }
                }

                if ($orderHasProduct) {
                    continue;
                }
//            }




            //ToDo : must consider donate in another place
//            if ($this->order->orderproducts->isNotEmpty()) {
//                $orderHasProduct = false;
//                foreach ($this->order->orderproducts as $singleOrderproduct) {
//                    if ($donateFlag) {
//                        $singleOrderproduct->delete();
//                    } else if ($productItem->id == $singleOrderproduct->product->id) {
//                        $orderHasProduct = true;
//                        // can increase amount of orderproduct
//                        // must be break ?????????????????
//                        continue;
//                    }
//                }
//                if ($orderHasProduct) {
//                    continue;
//                }
//            }


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
                 * end
                 */

                /**
                 * Obtaining product amount
                 */

                (new Product())->decreaseProductAmountWithValue($productItem, 1);
//                if (isset($productItem->amount)) {
//                    $productItem->amount = $productItem->amount - 1;
//                    $productItem->update();
//                }
                /**
                 * end
                 */


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

}