<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 12/16/2018
 * Time: 11:53 AM
 */

namespace App\Classes\Order\OrderProduct\RefinementProduct;

use App\Product;
use Mockery\Exception;

class RefinementFactory
{
    public $RefinementClass;

    public function __construct($productId, $data=null) {

        $product = Product::FindorFail($productId);

        $typeName = $product->producttype->name;

        $className = 'App\Classes\Order\OrderProduct\RefinementProduct\Refinement'.ucfirst($typeName);
        if(class_exists($className)) {
            $RefinementClass = new $className($product, $data);
//            return $RefinementClass;
            $this->RefinementClass = $RefinementClass;
        } else if($typeName=='configurable') {
            throw new Exception('Type Name {'.$typeName.'} not found.');
        }
//
//        scp ali@192.168.4.2:/project/tree/. /c/Users/Public/Desktop/

//        scp -r nameOfFolderToCopy username@ipaddress:/path/to/copy/


//        if($typeName == '') {
//            throw new Exception('Invalid Type Name.');
//        } else {
//            $className = 'Refinement'.ucfirst($typeName);
//            if(class_exists($className)) {
//                return new $className($inputs);
//            } else {
//                throw new Exception('Type Name not found.');
//            }
//        }
    }

    public function getRefinementClass() {
        return $this->RefinementClass;
    }
}