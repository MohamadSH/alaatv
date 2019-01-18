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
     * @param array $inputData
     * @param Refinement $refinement
     * @return array: [statusCode, message, user, order, cost, donateCost, transaction]
     */
    public function getData(array $inputData, Refinement $refinement) {
        return $refinement
                ->setData($inputData)
                ->validateData()
                ->loadData()
                ->getData();
    }
}