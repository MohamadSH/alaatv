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

class OrderproductBons
{
    private $user;
    private $order;
    private $orderProdutcs;

    public function __construct(User $user, Order $order) {
        $this->user = $user;
        $this->order = $order;
        $this->orderProdutcs = $this->order->orderproducts();
    }

    public function applyBons() {

        foreach ($this->orderProdutcs as $key=>$productItem) {

            $isFreeFlag = ($productItem->isFree || ($productItem->hasParents() && $productItem->parents()->first()->isFree));

            if (!$isFreeFlag &&
                $productItem->basePrice != 0 &&
                !$this->request->has("withoutBon")) {

                // get bons of product
                $bons = $this->getProductBons($productItem);

                // if product or parent have bon, record thtat
                if (!$bons->isEmpty()) {
                    $bon = $bons->first();
                    $userbons = $this->user->userValidBons($bon);
                    if (!$userbons->isEmpty()) {
                        foreach ($userbons as $userbon) {
                            $totalBonNumber = $userbon->totalNumber - $userbon->usedNumber;
                            $productItem->userbons()
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
            ->enable();
//                    ->where("isEnable", 1);

        // if product haven't bon check parents bons
        if ($bons->isEmpty()) {
            $parentsArray = $this->makeParentArray($product);
            if (!empty($parentsArray)) {
                foreach ($parentsArray as $parent) {
                    $bons = $this->getProductBons($parent);
                    if (!$bons->isEmpty())
                        break;
                }
            }
        }

        return $bons;
    }
}