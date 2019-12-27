<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 1/8/2019
 * Time: 1:20 PM
 */

namespace App\Classes\Payment\RefinementRequest;

use App\Classes\Payment\RefinementRequest\Strategies\{ChargingWalletRefinement,
    OpenOrderRefinement,
    OrderIdRefinement,
    TransactionRefinement};

class RefinementLauncher
{
    /**
     * @var Refinement $refinement
     */
    private $refinement;

    public function __construct($refinement)
    {
        $this->refinement = $this->gteRefinementRequestStrategy($refinement);
    }

    /**
     * @param array $inputData
     *
     * @return Refinement
     */
    private function gteRefinementRequestStrategy(array $inputData): Refinement
    {
        if (isset($inputData['transaction_id'])) { // closed order
            return new TransactionRefinement();
        } else if (isset($inputData['order_id'])) { // closed order
            return new OrderIdRefinement();
        } else if (isset($inputData['walletId']) && isset($inputData['walletChargingAmount'])) { // Charging Wallet
            return new ChargingWalletRefinement();
        } else { // open order
            return new OpenOrderRefinement();
        }
    }

    /**
     * @param array $inputData
     *
     * @return array: [statusCode, message, user, order, cost, donateCost, transaction]
     */
    public function getData(array $inputData)
    {
        return $this->refinement->setData($inputData)
            ->validateData()
            ->loadData()
            ->getData();
    }

}
