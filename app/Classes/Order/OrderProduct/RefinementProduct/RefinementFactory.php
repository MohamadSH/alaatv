<?php
/**
 * Created by PhpStorm.
 * User: Alaaa
 * Date: 12/16/2018
 * Time: 11:53 AM
 */

namespace App\Classes\Order\OrederProduct\RefinementProduct;

use Illuminate\Http\Request;

class RefinementFactory
{
    public function __construct(Request $request) {

        $productId = $request->get("product_id");
        $product = Product::FindorFail($productId);

        $typeName = $product->producttype->name;

        $className = 'Refinement'.ucfirst($typeName);
        if(class_exists($className)) {
            $RefinementClass = new $className($product, $request);
            return $RefinementClass;
        } else {
            throw new Exception('Type Name not found.');
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
}