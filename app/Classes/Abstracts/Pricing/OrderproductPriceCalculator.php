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
     *
     * @param $orderproduct
     */
    public function __construct($orderproduct)
    {
        $this->orderproduct = $orderproduct;
        $this->mode         = self::getDefaultMode();
    }

    /**
     * Gets default mode
     *
     * @return mixed
     */
    static public function getDefaultMode()
    {
        return self::ORDERPRODUCT_CALCULATOR_MODE_CALCULATE_FROM_BASE;
    }

    /**
     * @return string
     */
    public function getMode(): string
    {
        return $this->mode;
    }

    /**
     * @param string $mode
     *
     * @return OrderproductPriceCalculator
     */
    public function setMode(string $mode): OrderproductPriceCalculator
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * @return array
     */
    protected function getOrderproductPrice(): array
    {
        switch ($this->mode) {
            case self::ORDERPRODUCT_CALCULATOR_MODE_CALCULATE_FROM_BASE:
                $priceArray = $this->calculatePriceFromBase($this->orderproduct);
                break;
            case self::ORDERPRODUCT_CALCULATOR_MODE_CALCULATE_FROM_RECORD:
                $priceArray = $this->calculatePriceFromRecords($this->orderproduct);
                break;
            default:
                $priceArray = [];
                break;
        }

        return $priceArray;
    }

    /**
     * Gets intended Orderproduct calculated price
     *
     * @param Orderproduct $orderproduct
     *
     * @return array
     */
    protected function calculatePriceFromBase(Orderproduct $orderproduct): array
    {
        $priceArray = $this->obtainOrderproductPrice($orderproduct);

        return $priceArray;
    }

    /**
     * Calculates intended Orderproduct price
     *
     * @param Orderproduct $orderproduct
     * @param bool         $calculate
     *
     * @return array
     */
    protected function obtainOrderproductPrice(Orderproduct $orderproduct, $calculate = true): array
    {
        if ($calculate) {
            $product                   = $orderproduct->product;
            $priceArray                = $product->calculatePayablePrice();
            $price                     = $priceArray["cost"];
            $productDiscountPercentage = $priceArray["productDiscount"];
            $productDiscountValue      = $priceArray["productDiscountValue"];
            $productDiscountAmount     = $priceArray["productDiscountAmount"];
        } else {
            $price                     = $orderproduct->cost;
            $productDiscountValue      = $orderproduct->getOriginal("discountPercentage");
            $productDiscountPercentage = $orderproduct->discountPercentage;
            $productDiscountAmount     = $orderproduct->discountAmount;
        }


        $orderProductExtraPrice     = $orderproduct->getExtraCost();
        $totalBonDiscountPercentage = $orderproduct->getTotalBonDiscountPercentage();
        $totalBonDiscountValue      = $orderproduct->getTotalBonDiscountDecimalValue();

        $price = (int)$price;

        $customerPrice =
            (int)(($price * (1 - $productDiscountPercentage)) * (1 - $totalBonDiscountPercentage) - $productDiscountAmount);
        $discount      = $price - $customerPrice;
        $totalPrice    = $orderproduct->quantity * $customerPrice;

        return [
            ///////////////Details///////////////////////
            "cost"                      => $price,
            "extraCost"                 => $orderProductExtraPrice,
            "productDiscount"           => (int)$productDiscountValue,
            "productDiscountPercentage" => $productDiscountPercentage,
            'bonDiscount'               => $totalBonDiscountValue,
            'bonDiscountPercentage'     => $totalBonDiscountPercentage,
            "productDiscountAmount"     => (int)$productDiscountAmount,
            ////////////////////Total///////////////////////
            'customerCost'              => $customerPrice,
            'discount'                  => $discount,
            'totalCost'                 => $totalPrice,
        ];
    }

    /**
     * Gets intended Orderproduct price records
     *
     * @param Orderproduct $orderproduct
     *
     * @return array
     */
    protected function calculatePriceFromRecords(Orderproduct $orderproduct): array
    {
        $priceArray = $this->obtainOrderproductPrice($orderproduct, false);

        return $priceArray;
    }
}
