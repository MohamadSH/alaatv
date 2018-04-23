<?php namespace App\Traits;

use App\Product;
use Illuminate\Support\Facades\Config;

trait ProductCommon
{
    protected function makeChildrenArray ($product  , $type = "SIMPLE" , $enable = "ONLY_ENABLE" , $defaultProducts=null )
    {
        $childrenArray = array();
        switch ($type)
        {
            case "SIMPLE":
                if($enable == "ONLY_ENABLE")
                {
                    $children  = $product->children->where("enable" , 1)->sortBy("order");
                }
                 elseif($enable == "ALL" )
                 {
                     $children  = $product->children->sortBy("order");
                 }
                foreach ($children as $child)
                {
                    array_push($childrenArray , $child);
                    if(!$child->children->isEmpty())
                        $childrenArray = array_merge($childrenArray ,  $this->makeChildrenArray($child , "SIMPLE" , $enable));
                }
                break;
            case "NESTED":
                if($enable == "ONLY_ENABLE")
                    $children  = $product->children->where("enable" , 1)->sortBy("order");
                elseif($enable == "ALL")
                    $children  = $product->children->sortBy("order");

                foreach ($children as $child)
                {
                     $childAllAttributes = $child->getAllAttributes();
                    $simpleInfoAttributes = $childAllAttributes["simpleInfoAttributes"];
                    $grandChildren = $child->children;

                    if(isset($defaultProducts)) {
                        if (in_array($child->id , $defaultProducts))
                        {
                            if($grandChildren->isNotEmpty())
                                $defaultProducts = array_merge($defaultProducts , $grandChildren->pluck("id")->toArray());
                            $isDefault = 1;
                        }
                        else
                        {
                            $isDefault = 0;
                        }
                    }
                    else
                    {
                        $isDefault = $child->pivot->isDefault;
                    }
                    if($grandChildren->isEmpty())
                        array_push($childrenArray , ["product"=>$child , "children"=>[] , "parentId"=>$product->id , "isDefault" => $isDefault , "control"=>$child->pivot->control_id
                            , "cost"=>$child->basePrice  , "simpleInfoAttributes" => $simpleInfoAttributes , "description"=>$child->pivot->description]  );
                    else
                        array_push($childrenArray ,  ["product"=>$child,"children"=>$this->makeChildrenArray($child , "NESTED" , $enable , $defaultProducts) , "parentId"=>$product->id , "isDefault" => $isDefault ,
                            "control"=>$child->pivot->control_id , "cost"=>$child->basePrice  , "simpleInfoAttributes" => $simpleInfoAttributes , "description"=>$child->pivot->description]);
                }
                break;
            default:
                break;
        }

        return $childrenArray ;
    }

    protected function makeParentArray($myProduct)
    {
        $counter = 1 ;
        $parentsArray = array();
        while($myProduct->hasParents())
        {
            $parentsArray = array_add($parentsArray , $counter++ , $myProduct->parents->first() );
            $myProduct = $myProduct->parents->first() ;
        }
        return $parentsArray ;
    }

    protected function makeCostCollection($products)
    {
        $costCollection = collect();
        foreach ($products as $product)
        {
            if($product->producttype_id == 2)
            {
                $enableChildren = $product->children->where("enable" , 1);
                if($enableChildren->count() == 1 )
                {
                    $costArray = $enableChildren->first()->obtainProductCost();
                }else $costArray  = $product->obtainProductCost();

            }else $costArray  = $product->obtainProductCost();

            $costCollection->put( $product->id , ["cost"=>$costArray["cost"] , 'productDiscount'=>$costArray["productDiscount"] , 'bonDiscount'=>$costArray['bonDiscount'] ]);
        }
        return $costCollection ;
    }

    protected function makeProductCollection($productsId = null)
    {
        if(isset($productsId))
            $allProducts = Product::getProducts()->whereIn("id" , $productsId)->orderBy("created_at" , "Desc")->get();
        else
            $allProducts = Product::getProducts()->orderBy("created_at" , "Desc")->get();
        $products = collect();
        foreach ($allProducts as $product)
        {

            $childrenArray = $this->makeChildrenArray($product , "SIMPLE" , "ALL") ;
            $products->push(["product"=>$product  , "children"=>$childrenArray]) ;
        }

        return $products ;
    }

    protected function haveSameFamily($products)
    {
        $flag = true;
        foreach ($products as $key=>$product)
        {
            if(isset($products[$key+1])) {
                if ($product->getGrandParent() !== false && $products[$key + 1]->getGrandParent() !== false) {
                    if ($product->getGrandParent()->id != $products[$key + 1]->getGrandParent()->id) {
                        $flag = false;
                        break;
                    }
                } else {
                    $flag = false;
                    break;
                }
            }
        }
        return $flag ;
    }

    protected function makeProductLink($product)
    {
        $link = "" ;
        $grandParent = $product->getGrandParent() ;
        if( $grandParent !== false )
        {
            if($grandParent->enable)
                $link = action("ProductController@show" , $product->getGrandParent()) ;
        }else
        {
            if($product->enable)
                $link = action("ProductController@show" , $product) ;
        }
        return $link;
    }
}