<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 12/27/2018
 * Time: 11:37 AM
 */

namespace App\Traits\Cashier;

use Illuminate\Support\Collection;

trait CashierOrderproductUnit
{
    protected $rawOrderproductsToCalculateFromBase; //orderproducts that should be recalculated based on new conditions

    protected $rawOrderproductsToCalculateFromRecord; //orderproducts that should be calculated based recorded data

    protected $calculatedOrderproducts;

    /**
     * @param mixed $rawOrderproductsToCalculateFromBase
     * @return mixed
     */
    public function setRawOrderproductsToCalculateFromBase($rawOrderproductsToCalculateFromBase)
    {
        $this->rawOrderproductsToCalculateFromBase = $rawOrderproductsToCalculateFromBase;

        return $this;
    }

    /**
     * @param mixed $rawOrderproductsToCalculateFromRecord
     * @return mixed
     */
    public function setRawOrderproductsToCalculateFromRecord($rawOrderproductsToCalculateFromRecord)
    {
        $this->rawOrderproductsToCalculateFromRecord = $rawOrderproductsToCalculateFromRecord;

        return $this;
    }

    /**
     * @param Collection $calculatedOrderproducts
     * @return mixed
     */
    public function setCalculatedOrderproducts(Collection $calculatedOrderproducts)
    {
        $this->calculatedOrderproducts = $calculatedOrderproducts;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRawOrderproductsToCalculateFromBase()
    {
        return $this->rawOrderproductsToCalculateFromBase;
    }

    /**
     * @return mixed
     */
    public function getRawOrderproductsToCalculateFromRecord()
    {
        return $this->rawOrderproductsToCalculateFromRecord;
    }

    /**
     * @return Collection
     */
    public function getCalculatedOrderproducts(): ?Collection
    {
        return $this->calculatedOrderproducts;
    }
}