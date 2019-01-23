<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 1/21/2019
 * Time: 1:39 PM
 */

namespace App\Classes\Payment\GateWay;


use App\Http\Controllers\TransactionController;

class GateWayFactory
{
    private $transactionController;

    /**
     * @var GateWayAbstract $gateWayClass
     */
    private $gateWayClass;

    public function __construct(TransactionController $transactionController)
    {
        $this->transactionController = $transactionController;
    }

    /**
     * @param string $gateWay
     * @return GateWayAbstract
     */
    public function setGateWay(string $gateWay)
    {
        $className = $this->getGatewayNameSpace($gateWay);
        if (class_exists($className)) {
            $this->gateWayClass = new $className($this->transactionController);
        } else {
            throw new Exception('GateWay {' . $className . '} not found.');
        }
        return $this->gateWayClass;
    }

    /**
     * @param string $gateWay
     * @return string
     */
    private function getGatewayNameSpace(string $gateWay): string
    {
        $className = __NAMESPACE__ . '\\' . ucfirst($gateWay) . '\\' . ucfirst($gateWay);
        return $className;
    }
}