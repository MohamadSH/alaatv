<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 12/23/2018
 * Time: 1:17 PM
 */

namespace App\Traits;

use App\Classes\Facade\ControllerFacades\CallOrderproductControllerStoreFacade;
use Illuminate\Http\Request;


trait OrderproductControllerCommon
{

    /**
     * Stores an array of json objects , each containing of an orderproduct info
     *
     * @param $orderproductJsonObject
     * @param array $data
     * @return mixed
     */
    private function storeOrderproductJsonObject($orderproductJsonObject , array $data)
    {

        $orderproductInfo = json_decode($orderproductJsonObject);

        $grandParentProductId = optional($orderproductInfo)->product_id;
        $productIds = optional($orderproductInfo)->productIds;
        $attributes = optional($orderproductInfo)->attributes;
        $orderproductStoreRequest = new Request();
        $orderproductStoreRequest->offsetSet("product_id", $grandParentProductId);
        $orderproductStoreRequest->offsetSet("products", $productIds);
        $orderproductStoreRequest->offsetSet("attributes", $attributes);
        $orderproductStoreRequest->offsetSet("order_id" , isset($data["order_id"])?$data["order_id"]:null);

        $orderproductControllerFacade = new CallOrderproductControllerStoreFacade();

        $response = $orderproductControllerFacade->callStore($orderproductStoreRequest->all());

        return $response;
    }
}