<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 12/17/2018
 * Time: 4:38 PM
 */

namespace App\Classes\Order\OrderProduct;

use App\Product;
use App\Order;
use App\Orderproduct;

class GiftsOfProducts
{
    private $orderProdutcs;
    private $order;

    public function __construct(Order $order) {
        $this->order = $order;
        $this->orderProdutcs = $this->order->orderproducts();
    }

    public function addOrderGifts() {
        foreach ($this->orderProdutcs as $key=>$orderproductItem) {
            $giftsOfOrderProductItem = $orderproductItem->getGifts();
            foreach ($giftsOfOrderProductItem as $giftItem) {
                $orderHaveThisGift = $this->chengeTypeOfOrderpruductsToGift($giftItem);
                if(!$orderHaveThisGift) {
                    Orderproduct::attachGift($giftItem);
                }
            }
        }
    }

    /** chenge Type Of Orderpruduct That Is Gift Of Other OrderProduct To Gift
    *
    * @param Product $gift
    *
    * @return bool (order Have This Gift)
    */
    private function chengeTypeOfOrderpruductsToGift(Product $gift) {
        $orderHaveThisGift = false;
        foreach ($this->orderProdutcs as $key=>$orderproductItem) {
            if($gift->id===$orderproductItem->product_id){
                $orderHaveThisGift = true;
                $orderproduct = new Orderproduct();
                $orderproduct->changeOrderproductTypeToGift($orderproductItem->id);
                break;
            }
        }
        return $orderHaveThisGift;
    }

}