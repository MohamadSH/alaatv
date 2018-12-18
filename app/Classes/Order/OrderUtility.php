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
use Illuminate\Http\Request;

use App\Classes\Order\OrederProduct\RefinementProduct\RefinementFactory;
use App\Classes\Order\OrderProduct\OrderproductUtility;
use App\Classes\Order\OrderProduct\OrderproductBons;


class OrderUtility
{
    private $orderProdutcs;
    private $order;
    private $request;
    private $user;
    private $orderstatus;

    public function __construct(User $user, Order $order, Request $request) {
        $this->order = $order;
        $this->request = $request;
        $this->user = $user;
        $this->orderstatus = $this->order->orderstatus->id;
        $this->orderProdutcs = $this->order->orderproducts();
    }

    public function storeOrderProducts() {

//        $this->user->openOrders();

        $simpleProducts = (new RefinementFactory($this->request))->getProducts();

        (new OrderproductUtility($this->user, $this->order, $simpleProducts, $this->request))->store();

        (new OrderproductBons($this->user, $this->order))->applyBons();

        (new GiftsOfProducts($this->order))->addOrderGifts();

    }

}