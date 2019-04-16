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
     * @var Refinement $refinement
     */
    private $refinement;

    public function __construct(Refinement $refinement)
    {
        $this->refinement = $refinement;
    }

    /**
     * @param array $inputData
     * @return array: [statusCode, message, user, order, cost, donateCost, transaction]
     */
    public function getData(array $inputData)
    {
        return $this->refinement->setData($inputData)->validateData()->loadData()->getData();
    }
}