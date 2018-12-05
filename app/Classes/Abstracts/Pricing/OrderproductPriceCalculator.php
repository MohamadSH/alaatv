<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 12/2/2018
 * Time: 12:37 PM
 */

namespace App\Classes\Abstracts\Pricing;

use App\Orderproduct;

abstract class OrderproductPriceCalculator
{
    const ORDERPRODUCT_CALCULATOR_MODE_CALCULATE_FROM_BASE = "calculate_mode_from_base";
    const ORDERPRODUCT_CALCULATOR_MODE_CALCULATE_FROM_RECORD = "calculate_mode_from_record";

    protected $orderproduct;
    protected $mode;

    /**
     * OrderproductPriceCalculator constructor.
     * @param $orderproduct
     */
    public function __construct($orderproduct)
    {
        $this->orderproduct = $orderproduct;
        $this->mode = self::getDefaultMode();
    }

    /**
     * Gets default mode
     *
     * @return mixed
     */
    static public function getDefaultMode()
    {
        return self::ORDERPRODUCT_CALCULATOR_MODE_CALCULATE_FROM_BASE ;
    }

    /**
     * @param string $mode
     * @return OrderproductPriceCalculator
     */
    public function setMode(string $mode): OrderproductPriceCalculator
    {
        $this->mode = $mode;
        return $this;
    }

    /**
     * @return string
     */
    public function getMode(): string
    {
        return $this->mode;
    }

    /**
     * @return array
     */
    protected function getOrderproductPrice() : array
    {
        switch ($this->mode)
        {
            case self::ORDERPRODUCT_CALCULATOR_MODE_CALCULATE_FROM_BASE:
                $priceArray = $this->calculatePriceFromBase($this->orderproduct);
                break;
            case self::ORDERPRODUCT_CALCULATOR_MODE_CALCULATE_FROM_RECORD:
                $priceArray =  $this->calculatePriceFromRecords($this->orderproduct);
                break;
            default:
                $priceArray = [];
                break;
        }

        return $priceArray;
    }

    /**
     * Gets intended Orderproduct price records
     *
     * @param Orderproduct $orderproduct
     * @return array
     */
    protected function calculatePriceFromRecords(Orderproduct $orderproduct) :array
    {
        $priceArray = $this->obtainOrderproductPrice( $orderproduct , false);
        return $priceArray ;
    }

    /**
     * Gets intended Orderproduct calculated price
     *
     * @param Orderproduct $orderproduct
     * @return array
     */
    protected function calculatePriceFromBase(Orderproduct $orderproduct) :array
    {
        $priceArray = $this->obtainOrderproductPrice($orderproduct);

        //ToDo: Does not belong here
        /** Updating orderproduct cost with new numbers*/
        $orderproduct->fillCostValues($priceArray);
        $orderproduct->update();
        /** End */

        return $priceArray ;
    }

    /**
     * Calculates intended Orderproduct price
     *
     * @param Orderproduct $orderproduct
     * @param bool $calculate
     * @return array
     */
    protected function obtainOrderproductPrice(Orderproduct $orderproduct , $calculate = true) :array
    {
        $price = 0;
        $bonDiscount = 0;
        $productDiscount = 0;
        $productDiscountAmount = 0;
        $orderProductExtraPrice = 0;
        if ($calculate) {
            $product = $orderproduct->product;
            if ($product->isFree)
                $price = null;
            else {
                $priceArray = $product->calculatePayablePrice();
                $price = $priceArray["cost"];
                $productDiscount = $priceArray["productDiscount"];
                $productDiscountAmount = $priceArray["productDiscountAmount"];

                foreach ($orderproduct->attributevalues as $attributevalue) {
                    $orderProductExtraPrice += $attributevalue->pivot->extraCost;
                }

                $userbons = $orderproduct->userbons;
                foreach ($userbons as $userbon) {
                    $bons = $product->bons->where("id", $userbon->bon_id)
                        ->where("isEnable", 1);
                    if ($bons->isEmpty()) {
                        $parentsArray = $orderproduct->makeParentArray($product);
                        if (!empty($parentsArray)) {
                            foreach ($parentsArray as $parent) {
                                $bons = $parent->bons->where("id", $userbon->bon_id)
                                    ->where("isEnable", 1);
                                if (!$bons->isEmpty())
                                    break;
                            }
                        }
                    }
                    if (!$bons->isEmpty()) {
                        $bonDiscount += $userbon->pivot->discount * $userbon->pivot->usageNumber;
                    }
                }
            }
        } else {
            $price = $orderproduct->cost;
            $productDiscount = $orderproduct->discountPercentage;
            $productDiscountAmount = $orderproduct->discountAmount;

            foreach ($orderproduct->attributevalues as $attributevalue) {
                $orderProductExtraPrice += $attributevalue->pivot->extraCost;
            }

            $userbons = $orderproduct->userbons;
            foreach ($userbons as $userbon) {
                $bonDiscount += $userbon->pivot->discount * $userbon->pivot->usageNumber;
            }
        }

        $price = (int)$price;

        $customerPrice = (int)(($price * (1 - ($productDiscount / 100))) * (1 - ($bonDiscount / 100)) - $productDiscountAmount);
        $totalPrice = $orderproduct->quantity * $customerPrice;

        return [
            "cost"                  => $price,
            "extraCost"             => $orderProductExtraPrice,
            "productDiscount"       => $productDiscount,
            'bonDiscount'           => $bonDiscount,
            "productDiscountAmount" => (int)$productDiscountAmount,
            'customerCost'          => $customerPrice,
            'totalCost'             => $totalPrice
        ];
    }
}