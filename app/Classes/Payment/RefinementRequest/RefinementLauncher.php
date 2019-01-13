<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 1/8/2019
 * Time: 1:20 PM
 */

namespace App\Classes\Payment\RefinementRequest;

use Illuminate\Http\Request;

class RefinementLauncher
{
    /**
     * @var Refinement
     */
    private $refinement;

    /**
     * @var Request
     */
    private $request;

    /**
     * RefinementLauncher constructor.
     * @param Request $request
     * @param Refinement $refinement
     */
    public function __construct(Request $request, Refinement $refinement) {
        $this->refinement = $refinement;
        $this->request = $request;
    }

    /**
     * @return array: [statusCode, message, user, order, cost, donateCost, transaction]
     */
    public function getData() {
        return $this->refinement
            ->setRequest($this->request)
            ->getData();
    }
}