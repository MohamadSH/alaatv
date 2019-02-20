<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 11/26/2018
 * Time: 5:12 PM
 */

namespace App\Collection;

use App\Orderproduct;
use App\Traits\JsonResponseFormat;
use Illuminate\Database\Eloquent\Collection;
use App\Classes\Checkout\Alaa\GroupOrderproductCheckout;
use App\Classes\Abstracts\Pricing\OrderproductPriceCalculator;

class OrderproductCollection extends Collection
{
    const MODE = OrderproductPriceCalculator::ORDERPRODUCT_CALCULATOR_MODE_CALCULATE_FROM_BASE;

    private $newPrices = [];

    use JsonResponseFormat;

    /**
     * Sets new price value in Newprices array for an item in the orderproduct collection
     * indexing it with orderproduct's id
     *
     * @param Orderproduct $orderproduct
     * @param $newPrice
     * @return array
     */
    public function setNewPriceForItem(Orderproduct $orderproduct , $newPrice):array
    {
        $orderproductId = $orderproduct->id ;
        if(in_array($orderproductId , $this->pluck("id")->toArray()))
            $this->newPrices[$orderproductId] = $newPrice;

        return $this->newPrices;
    }

    /**
     * Gets new price value for an item in an Orderproduct collection
     *
     * @param Orderproduct $orderproduct
     * @return mixed|null
     */
    public function getNewPriceForItem(Orderproduct $orderproduct)
    {
        $orderproductId = $orderproduct->id ;
        $newPrice = null ;
        if(isset($this->newPrices[$orderproductId]))
            $newPrice = $this->newPrices[$orderproductId];

        return $newPrice;
    }

    public function merge($items)
    {
        $totalNewPrices =  $this->mergeNewPrices($items);
        $newTotalColection =  parent::merge($items);
        $newTotalColection->newPrices = $totalNewPrices;

        return $newTotalColection;
    }

    /**
     * Merges two collections new prices
     *
     * @param $items
     * @return array
     */
    public function mergeNewPrices($items):array
    {
        $myNewPrices = $this->newPrices;
        $otherNewPrices = $items->newPrices;
        $totalNewPrices =  $myNewPrices + $otherNewPrices;

        return $totalNewPrices;
    }

    public function updateCostValues()
    {
        foreach ($this as $orderproduct)
        {
            $newPriceInfo = $this->getNewPriceForItem($orderproduct);

            $orderproduct->fillCostValues($newPriceInfo);
            $orderproduct->update();
        }
    }

    /**
     * Updates orderproduct items' cost up to new conditions
     *
     * @return void
     * @throws \Exception
     */
    public function reCheckOrderproducs():void
    {
        foreach ($this as $orderproduct) {
            if (!$orderproduct->isPurchasable()) {
                $orderproduct->delete();
            } else {

                //ToDo : Should be removed and be replaced with an event
                $orderproduct->renewAttributeValue();

                //ToDo : If there should be a rule like this , this should be replaced with an event
//                $orderproduct->renewUserBons();

                $orderproduct->fresh();
            }
        }
    }

    /**
     * @return array
     */
    public function getNewPrices(): array
    {
        return $this->newPrices;
    }

    /**
     * Makes links of every orderproduct
     *
     * @return mixed
     */
    public function makeLinks():\Illuminate\Support\Collection{
        $orderproductLinks = collect();
        foreach ($this as $orderproduct)
        {
            $orderproductLink = $orderproduct->product->makeProductLink();
            if (strlen($orderproductLink) > 0)
                $orderproductLinks->put($orderproduct->id, $orderproductLink);
        }
        return $orderproductLinks;
    }

    /**
     * Calculates orderproducts prices of this collection
     *
     * @return array
     */
    public function calculateGroupPrice(){
        $alaaGroupOrderproductCollection = new GroupOrderproductCheckout($this , $this->pluck("id")->toArray());
        $priceInfo = $alaaGroupOrderproductCollection->checkout();
        $calculatedOrderproducts = $priceInfo["orderproductsInfo"]["calculatedOrderproducts"];
        $newPrices = $calculatedOrderproducts->newPrices;
        $rawCost = $priceInfo["totalPriceInfo"]["sumOfOrderproductsRawCost"];
        $customerCost = $priceInfo["totalPriceInfo"]["sumOfOrderproductsCustomerCost"];

        return [
            "newPrices" => $newPrices,
            "rawCost" => $rawCost,
            "customerCost" => $customerCost,
        ];
    }

    /**
     *  Filters type of orderproducts of this collection
     * @param array $type
     * @return OrderproductCollection
     */
    public function whereType(array $type){
        return $this->whereIn("orderproducttype_id" , $type);
    }


    /**
     * Makes a ProductCollection having every orderprodcut's product
     *
     * @return ProductCollection
     */
    public function getProducts()
    {
        $products = new ProductCollection();
        foreach ($this as $orderproduct)
        {
            $products->push($orderproduct->product);
        }

        return $products;
    }
}