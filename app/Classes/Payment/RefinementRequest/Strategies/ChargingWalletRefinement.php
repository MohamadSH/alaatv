<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 1/8/2019
 * Time: 1:29 PM
 */

namespace App\Classes\Payment\RefinementRequest\Strategies;

use Illuminate\Http\Response;
use App\Classes\Payment\RefinementRequest\{Refinement, RefinementInterface};

class ChargingWalletRefinement extends Refinement
{

    /**
     * @return Refinement
     */
    function loadData(): Refinement
    {
        if($this->statusCode!=Response::HTTP_OK) {
            return $this;
        }

        $this->description .= 'شارژ کیف پول -';
        $this->cost = $this->walletChargingAmount;
        $result = $this->getNewTransaction(false);
        $this->statusCode = $result['statusCode'];
        $this->message = $result['message'];
        $this->transaction = $result['transaction'];
        $this->statusCode = Response::HTTP_OK;

        return $this;
    }
}