<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 1/8/2019
 * Time: 1:20 PM
 */

namespace App\Classes\Payment\RefinementRequest;

class RefinementLauncher
{
    /**
     * @var Refinement
     */
    private $refinement;

    /**
     * @var array
     */
    private $inputData;

    /**
     * RefinementLauncher constructor.
     * @param array $inputData
     * @param Refinement $refinement
     */
    public function __construct(array $inputData, Refinement $refinement) {
        $this->refinement = $refinement;
        $this->inputData = $inputData;
    }

    /**
     * @return array: [statusCode, message, user, order, cost, donateCost, transaction]
     */
    public function getData() {
        return $this->refinement
            ->setData($this->inputData)
            ->validateData()
            ->loadData()
            ->getData();
    }
}