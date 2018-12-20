<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 12/18/2018
 * Time: 5:19 PM
 */

namespace App\Classes\Order\OrderProduct;

use App\Product;
use App\Order;
use App\User;
use App\Orderproduct;
use App\Traits\ProductCommon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class OrderproductBons
{
    use ProductCommon;

    public function __construct(User $user, Order $order, $data) {
        $this->user = $user;
        $this->order = $order;
        $this->data = $data;
        $this->orderProdutcs = $this->order->orderproducts()->get();
    }

    public function applyBons() {

        // put all product and orderProduct together in one array
//        $savedOrderProductWithProductModel = $this->getSavedOrderProductWithProductModel();

        foreach ($this->orderProdutcs as $key=>$value) {
            $isFreeFlag = ($value->product->isFree || ($value->product->hasParents() && $value->product->parents()->first()->isFree));

            if (!$isFreeFlag &&
                $value->product->basePrice != 0 &&
                !isset($this->data["withoutBon"])) {


                // get bons of product
                $bons = $this->getProductBons($value->product->id);

                // if product or parent have bon, record thtat
                if (!$bons->isEmpty()) {
                    $bon = $bons->first();
                    $userbons = $this->user->userValidBons($bon);
                    if (!$userbons->isEmpty()) {
                        foreach ($userbons as $userbon) {
                            $totalBonNumber = $userbon->totalNumber - $userbon->usedNumber;
                            $value->userbons()
                                ->attach($userbon->id, [
                                    "usageNumber" => $totalBonNumber,
                                    "discount"    => $bon->pivot->discount,
                                ]);
                            $userbon->usedNumber = $userbon->usedNumber + $totalBonNumber;
                            $userbon->userbonstatus_id = Config::get("constants.USERBON_STATUS_USED");
                            $userbon->update();
                        }
                        Cache::tags('bon')->flush();
                    }
                }
            }
        }
    }

    private function getProductBons($productId) {

        $product = Product::findOrFail($productId);
        $bonName = config("constants.BON1");
        $bons = $product->bons->where("name", $bonName)
            ->where("pivot.discount", ">", "0")
//            ->enable();
            ->where("isEnable", 1);

        // if product haven't bon check parents bons
        if ($bons->isEmpty()) {
            $parentsArray = $this->makeParentArray($product);
            if (!empty($parentsArray)) {
                foreach ($parentsArray as $parent) {
                    $bons = $this->getProductBons($parent->id);
                    if (!$bons->isEmpty())
                        break;
                }
            }
        }

        return $bons;
    }

}