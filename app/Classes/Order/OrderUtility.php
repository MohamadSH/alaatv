<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 12/18/2018
 * Time: 1:58 PM
 */

namespace App\Classes\Order;

use App\Order;
use App\User;

use App\Classes\Order\OrderProduct\RefinementProduct\RefinementFactory;
use App\Classes\Order\OrderProduct\OrderproductUtility;
use App\Classes\Order\OrderProduct\OrderproductBons;
use App\Classes\Order\OrderProduct\OrderProductGifts;


class OrderUtility
{
    private $orderProdutcs;
    private $order;
    private $productId;
    private $user;
    private $orderstatus;
    private $data; // withoutBon, extraAttribute, attributes or product ids in array

    public function __construct(User $user, Order $order, $productId, $data) {
        $this->order = $order;
        $this->productId = $productId;
        $this->data = $data;
        $this->user = $user;
        $this->orderstatus = $this->order->orderstatus->id;
//        $this->orderProdutcs = $this->order->orderproducts();
    }

    public function storeOrderProducts() {

//        $this->user->openOrders();

        $simpleProducts = (new RefinementFactory($this->productId, $this->data))->getRefinementClass()->getProducts();

        (new OrderproductUtility($this->user, $this->order, $simpleProducts, $this->data))->store();

        (new OrderproductBons($this->user, $this->order, $this->data))->applyBons();

        (new OrderProductGifts($this->order))->addOrderGifts();

        dd($this->getOrderPrductIds());


    }

    private function getOrderPrductIds() {
        $array['OrderPrductIds'] = [];
        $orderproduct = $this->order->orderproducts()->get();
        foreach ($orderproduct as $item) {
            $array['OrderPrductIds'][] = $item->product_id;
        }
        return $array;
    }

}