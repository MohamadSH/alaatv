<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 1/21/2019
 * Time: 1:39 PM
 */

namespace App\Classes\Payment\GateWay;


class GateWayFactory
{
    /**
     * @var GateWayAbstract $gateWayClass
     */
    private $gateWayClass;

    /**
     * @param string $gateWay
     * @param string $merchantID
     * @return GateWayAbstract
     */
    public function setGateWay(string $gateWay, string $merchantID)
    {
        $className = $this->getGatewayNameSpace($gateWay);
        if (class_exists($className)) {
            $this->gateWayClass = new $className($merchantID);
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