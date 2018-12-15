<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 11/26/2018
 * Time: 5:12 PM
 */

namespace App\Collection;

use App\Classes\Abstracts\Pricing\OrderproductPriceCalculator;
use App\Classes\Pricing\Alaa\AlaaOrderproductPriceCalculator;
use App\Http\Controllers\OrderproductController;
use App\Orderproduct;
use Illuminate\Database\Eloquent\Collection;

class OrderproductCollection extends Collection
{
    const MODE = OrderproductPriceCalculator::ORDERPRODUCT_CALCULATOR_MODE_CALCULATE_FROM_BASE;

    private $newPrices = [];

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
     * @return array
     */
    public function renewOrderproducs()
    {
        $totalRawCost = 0;
        /** Updating each orderproduct */

        foreach ($this as $orderproduct) {
            if (!$orderproduct->isPurchasable()) {
                $orderproductController = new OrderproductController();
                $orderproductController->destroy($orderproduct);
            } else {

                //ToDo : Should be removed and be replaced with an event
                $orderproduct->renewAttributeValue();

                //ToDo : If there should be a rule like this , this should be replaced with an event
//                $orderproduct->renewUserBons();

                $orderproduct->fresh();

                //ToDo : Should be removed and be replaced with an event
                $orderproductCost = $orderproduct->obtainOrderproductCost();

                $orderproduct->fillCostValues($orderproductCost);

                $totalRawCost += $orderproductCost["cost"] + $orderproductCost["extraCost"];

                $orderproduct->update();
            }
        }
        /** end */

        return [
            "rawCost"       => $totalRawCost,
        ];
    }
}