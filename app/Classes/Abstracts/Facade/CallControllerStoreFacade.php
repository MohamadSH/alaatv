<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 12/22/2018
 * Time: 12:00 PM
 */

namespace App\Classes\Abstracts\Facade;


use App\Classes\Factory\ControllerFactory;
use App\Http\Controllers\Controller;
use App\Traits\RequestCommon;
use Illuminate\Foundation\Http\FormRequest;

abstract class CallControllerStoreFacade
{
    use RequestCommon;

    /**
     * Calls store method of intended controller class
     *
     * @param array $data
     * @return mixed
     */
    public function callStore(array $data){
        $storeRequest = $this->getStoreRequest();
        $storeRequest->merge($data);
        RequestCommon::convertRequestToAjax($storeRequest);
        $controllerObject = $this->getControllerObject();
        $response = $controllerObject->store($data);
        return $response;
    }

    /**
     * Make appropriate request for Store method
     *
     * @return mixed
     */
    protected function getStoreRequest():FormRequest{
        return new FormRequest();
    }

    /**
     * @return Controller
     */
    protected function getControllerObject():Controller
    {
        return ControllerFactory::getControllerObject($this->getControllerName());
    }

    /**
     * @return string
     */
    abstract protected function getControllerName():string ;
}