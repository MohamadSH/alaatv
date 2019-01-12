<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 1/8/2019
 * Time: 1:20 PM
 */

namespace App\Classes\Payment\RefinementRequest;

use App\Classes\Payment\RefinementRequest\Refinement;

class RefinementLauncher
{
    /**
     * @var Refinement
     */
    private $refinement;

    /**
     * RefinementLauncher constructor.
     * @param Refinement $refinement
     */
    public function __construct(Refinement $refinement) {
        $this->refinement = $refinement;
    }

    /**
     * @return array: [statusCode, message, user, order, cost, donateCost, transaction]
     */
    public function getData() {
        return $this->refinement->getData();
    }
}