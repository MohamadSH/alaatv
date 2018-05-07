<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Attributeset;
use App\Attributetype;
use App\Attributevalue;
use App\Bon;
use App\Http\Requests\AddComplimentaryProductRequest;
use App\Http\Requests\EditProductRequest;
use App\Http\Requests\InsertProductRequest;
use App\Product;
use App\Productfiletype;
use App\Traits\Helper;
use App\Traits\ProductCommon;
use App\User;
use App\Websitepage;

use App\Websitesetting;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use SEO;

class ProductController extends Controller
{
    use Helper;
    protected $response ;
    protected $setting ;
    use ProductCommon;

    function __construct()
    {
        $this->middleware('permission:'.Config::get('constants.LIST_PRODUCT_ACCESS'),['only'=>'index']);
        $this->middleware('permission:'.Config::get('constants.INSERT_PRODUCT_ACCESS'),['only'=>'create']);
        $this->middleware('permission:'.Config::get('constants.REMOVE_PRODUCT_ACCESS'),['only'=>'destroy']);
        $this->middleware('permission:'.Config::get('constants.SHOW_PRODUCT_ACCESS'),['only'=>'edit']);
        $this->middleware('permission:'.Config::get('constants.EDIT_PRODUCT_ACCESS'),['only'=>'update']);
        $this->middleware('permission:'.Config::get('constants.EDIT_CONFIGURE_PRODUCT_ACCESS'),['only'=> ['childProductEnable' , 'completeEachChildPivot']]);
        $this->middleware('permission:'.Config::get('constants.INSERT_CONFIGURE_PRODUCT_ACCESS'),['only'=>'makeConfiguration' , 'createConfiguration']);
        $this->middleware('auth', ['except' => ['show' , 'refreshPrice' , 'search' , 'showPartial' , 'landing1' , 'landing2' , 'landing3' , 'landing4' ]]);

        $this->response = new Response();
        $this->setting = json_decode(app('setting')->setting);

    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::getProducts()->orderBy('created_at' , 'Desc')->get() ;
        return view("product.index" , compact("products" ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InsertProductRequest $request)
    {
        $product = new Product();
        $product->fill($request->all());

        if(strlen($request->get("introVideo"))>0)
            if(!preg_match("/^http:\/\//", $product->introVideo) && !preg_match("/^https:\/\//", $product->introVideo) )
                 $product->introVideo = "https://". $product->introVideo ;

        if ($request->hasFile("file")) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $fileName = basename($file->getClientOriginalName() , ".".$extension) . "_" . date("YmdHis") . '.' . $extension;
            if (Storage::disk(Config::get('constants.DISK5'))->put($fileName, File::get($file))) {
                $product->file = $fileName;
            }
        }

        if ($request->hasFile("image")) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileName = basename($file->getClientOriginalName() , ".".$extension) . "_" . date("YmdHis") . '.' . $extension;
            if (Storage::disk(Config::get('constants.DISK4'))->put($fileName, File::get($file))) {
                $product->image = $fileName;
//                $img = Image::make(Storage::disk(Config::get('constants.DISK4'))->getAdapter()->getPathPrefix().$fileName);
//                $img->resize(256, 256);
//                $img->save(Storage::disk(Config::get('constants.DISK4'))->getAdapter()->getPathPrefix().$fileName);
            }

        }

        if ($request->get('amountLimit') == 0){
            $product->amount = null;
        }
        $bon = Bon::where('id', $request->get('bon_id'))->first();
        if(strlen($request->get('bonPlus')) == 0) $bonPlus = 0; else $bonPlus = $request->get('bonPlus');
        if(strlen($request->get('bonDiscount')) == 0) $bonDiscount = 0; else $bonDiscount = $request->get('bonDiscount');

        if($request->has("isFree")) $product->isFree = 1;
        else $product->isFree = 0;

        if(strlen(preg_replace('/\s+/', '', $product->discount)) == 0) $product->discount = 0;

        if($request->has("order"))
        {
            if(strlen(preg_replace('/\s+/', '', $request->get("order"))) == 0) $product->order = 0;
            $productsWithSameOrder = Product::getProducts(0 , 1)->where("order" , $product->order)->get();
            if(!$productsWithSameOrder->isEmpty())
            {
                $productsWithGreaterOrder =  Product::getProducts(0 , 1)->where("order" ,">=" ,$product->order)->get();
                foreach ($productsWithGreaterOrder as $graterProduct)
                {
                    $graterProduct->order = $graterProduct->order + 1 ;
                    $graterProduct->update();
                }
            }
        }

        if ($product->save()) {
            if($bonPlus || $bonDiscount)
                $product->bons()->attach($bon->id, ['discount' => $bonDiscount, 'bonPlus' => $bonPlus]);
            return $this->response->setStatusCode(200);
        }
        else{
            return $this->response->setStatusCode(503);
        }
    }


    private function addSimpleInfoAttributes(Product &$product){
        $productsArray = [];
        array_push($productsArray, $product);

        while (count($productsArray)){
            $pop = array_pop($productsArray);
            if(!isset($pop['simpleInfoAttributes'])){
                $allAttributeCollection = $pop->getAllAttributes() ;
                $pop['simpleInfoAttributes'] = $allAttributeCollection["simpleInfoAttributes"];
            }
            foreach ($pop->children as &$p){
                array_push($productsArray, $p);
            }
        }
    }
    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $product)
    {
        $defaultProducts = null;
        if($request->has("dp")) {
            $defaultProducts = [];
            array_push($defaultProducts , (int)$request->dp);
        }

        if(in_array($product->id , [193,194,195]))
            return redirect(action("ProductController@show" , 184), 301);

        $url = $request->url();
        SEO::opengraph()->setUrl($url);
        SEO::setCanonical($url);
        SEO::twitter()->setSite("آلاء");
        SEO::setTitle($product->name);
        SEO::setDescription($product->shortDescription);
        if(isset($files['thumbnail']))
            SEO::opengraph()->addImage(route('image', ['category'=>'4','w'=>'338' , 'h'=>'338' ,  'filename' =>  $product->image ]), ['height' => 338, 'width' => 338]);
        else
            SEO::opengraph()->addImage(route('image', ['category'=>'11','w'=>'100' , 'h'=>'100' ,  'filename' =>  $this->setting->site->siteLogo ]), ['height' => 100, 'width' => 100]);
        SEO::opengraph()->setType('website');


        $descriptionIframe = $request->partial;
        $productType = $product->producttype->id;

        $allAttributeCollection = $product->getAllAttributes() ;

        $this->addSimpleInfoAttributes($product);
        //return $product;

        $selectCollection = $allAttributeCollection["selectCollection"];
        $groupedCheckboxCollection = $allAttributeCollection["groupedCheckboxCollection"];
        $extraSelectCollection = $allAttributeCollection["extraSelectCollection"];
        $extraCheckboxCollection = $allAttributeCollection["extraCheckboxCollection"];
        $simpleInfoAttributes = $allAttributeCollection["simpleInfoAttributes"];
        $checkboxInfoAttributes = $allAttributeCollection["checkboxInfoAttributes"];


//        return $checkboxInfoAttributes;

        if(session()->has("adminOrder_id"))
            $user = User::where("id" , session()->get("customer_id"))->first();
        elseif(Auth::check())
            $user = Auth::user();

//        return response()->make("Ok".$product->id.":".$productType);

        if(isset($user))
            $costArray = $product->calculatePayablePrice( $user );
        else
            $costArray = $product->calculatePayablePrice( );

        $discount = $costArray["bonDiscount"]+$costArray["productDiscount"];
        $cost = $costArray["cost"];

        if(Config::has("constants.EXCLUDED_RELATED_PRODUCTS"))
            $excludedProducts = Config::get("constants.EXCLUDED_RELATED_PRODUCTS");
        else
            $excludedProducts = [] ;


        $key="product:otherProducts:".$product->cacheKey();
        $otherProducts = Cache::remember($key,Config::get("constants.CACHE_60"),function () use ($product,$excludedProducts){
            $otherProducts = Product::getProducts(0,1)
                ->whereNotIn("id",$excludedProducts)
                ->orderBy('created_at' , 'Desc')
                ->where("id","<>" , $product->id)->get();
            return $otherProducts;
        });
        $otherProductChunks = $otherProducts->chunk(4);

        if(Config::has("constants.EXCLUSIVE_RELATED_PRODUCTS"))
            $exclusiveOtherProductIds = Config::get("constants.EXCLUSIVE_RELATED_PRODUCTS");
        else
            $exclusiveOtherProductIds = [] ;

        $key="product:exclusiveOtherProducts:".md5(implode(".",$exclusiveOtherProductIds));
        $exclusiveOtherProducts = Cache::remember($key,Config::get("constants.CACHE_60"),function () use ($exclusiveOtherProductIds){
            $exclusiveOtherProducts = Product::whereIn("id" , $exclusiveOtherProductIds)->get();
            return $exclusiveOtherProducts;

        });
//        $disqusPayload = Auth::user()->disqusSSO();

        if(Auth::check())
        {
            $baseUrl = url("/");
            $productPath = str_replace($baseUrl , "" , action("ProductController@show" , $product));
            $productSeenCount = $this->userSeen($productPath);

        }
        if(isset($product->introVideo) && strlen($product->introVideo) > 0)
             $productIntroVideo = $product->introVideo;



        $key="product:validProductfiles:pamphlet|video".$product->cacheKey();

        [$productsWithPamphlet,$productsWithVideo] = Cache::remember($key,Config::get("constants.CACHE_60"),function () use ($product){

            /** Product files */
            $productsWithPamphlet = collect();
            //////////////////////////////PAMPHLETS////////////////////////////////////
            $filesArray = [];
            $productsFiles = $product->validProductfiles("pamphlet")->get();
            foreach($productsFiles as $productfile)
            {
                array_push($filesArray, ["file" => $productfile->file, "name" => $productfile->name , "product_id"=>$productfile->product_id]);
            }
            if(!empty($filesArray))
                $productsWithPamphlet->put($product->name,$filesArray);

            foreach ($product->children as $child)
            {
                $filesArray = [];
                $productsFiles = $child->validProductfiles("pamphlet")->get();
                foreach( $productsFiles as $productfile)
                {
                    array_push($filesArray, ["file" => $productfile->file, "name" => $productfile->name , "product_id"=>$productfile->product_id]);
                }
                if(!empty($filesArray))
                    $productsWithPamphlet->put($child->name,$filesArray);
            }

            ////////////////////////////    VIDEOS /////////////////////////
            $productsWithVideo = collect();
            $filesArray = array();
            foreach($product->validProductfiles("video")->get() as $productfile)
            {
                array_push($filesArray, ["file" => $productfile->file, "name" => $productfile->name , "product_id"=>$productfile->product_id]);
            }
            if(!empty($filesArray)) $productsWithVideo->put($product->name,$filesArray);
            foreach ($product->children as $child)
            {
                $filesArray = array();
                foreach($child->validProductfiles("video")->get() as $productfile)
                {
                    array_push($filesArray, ["file" => $productfile->file, "name" => $productfile->name , "product_id"=>$productfile->product_id]);
                }
                if(!empty($filesArray)) $productsWithVideo->put($child->name,$filesArray);
            }

            return [$productsWithPamphlet,$productsWithVideo];
        });

        /**
         * Product sample photos
         */
        $key="product:SamplePhotos:".$product->cacheKey();
        $productSamplePhotos = Cache::remember($key,Config::get("constants.CACHE_60"),function () use ($product){
            return $product->photos->where("enable" , 1)->sortBy("order");
        });

        /**
         * end of product sample photos
         */

        /**
         * Product gifts
         */
        $key="product:Gifts:".$product->cacheKey();
        $giftCollection =  Cache::remember($key,Config::get("constants.CACHE_60"),function () use ($product){
            $gCollection = collect();
            $gifts = $product->gifts;

            foreach ($gifts as $gift)
            {
                $gCollection->push(["product"=>$gift , "link"=>$this->makeProductLink($gift)]);
            }
            return $gCollection;
        });

        /**
         * end of product gifts
         */


        $isLive = $product->isHappening();
        if(Auth::check() && Auth::user()->hasRole("admin") && $isLive!== false) $isLive = 0 ;
//        return response()->make("Ok");
        return view("product.show" , compact("product" , "productType" ,"productSeenCount","productIntroVideo" , "otherProductChunks"  , 'discount' , 'cost' , "selectCollection" ,"simpleInfoAttributes"
            , "checkboxInfoAttributes" , "extraSelectCollection" , "extraCheckboxCollection" , 'groupedCheckboxCollection'  , "descriptionIframe"
            , "isProductExistInOrder"  , "productsWithVideo" , "productsWithPamphlet" , "exclusiveOtherProducts" , "productSamplePhotos" , "giftCollection" , "isLive" ));
    }

    /**
     * Display partial information of the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function showPartial($product){
        return redirect(action("ProductController@show" , $product)."?partial=true");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \app\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($product)
    {
        $amountLimit = [
            0 => 'نامحدود',
            1 => 'محدود'
        ];
        if(isset($product->amount)){$defaultAmountLimit = 1;}
        else{$defaultAmountLimit = 0;}

        $enableStatus = [
            0 => 'غیرفعال',
            1 => 'فعال'
        ];
        if(isset($product->enable) && $product->enable){$defaultEnableStatus = 1;}
        else{$defaultEnableStatus = 0;}

        $attributesets = Attributeset::pluck('name' , 'id')->toArray();

        $bonName = Config::get("constants.BON1");
        $bons = $product->bons->where("name" , $bonName)->where("isEnable" , 1);
        if($bons->isEmpty()) $bons = Bon::where('name', $bonName)->first();
        else $bons = $bons->first();

        $productFiles = $product->productfiles->sortBy("order");
        $productFileTypes = Productfiletype::pluck('displayName', 'id')->toArray();
        $defaultProductFileOrders = collect();
        foreach ($productFileTypes as $key=>$productFileType)
        {
            $lastProductFile = $product->productfiles->where("productfiletype_id" , $key)->sortByDesc("order")->first();
            if(isset($lastProductFile))
            {
                $lastOrderNumber = $lastProductFile->order + 1;
                $defaultProductFileOrders->push(["fileTypeId"=>$key , "lastOrder"=>$lastOrderNumber]);
            }else{
                $defaultProductFileOrders->push(["fileTypeId"=>$key , "lastOrder"=>1]);
            }
        }
        $productFileTypes = array_add($productFileTypes , 0 , "انتخاب کنید");
        $productFileTypes = array_sort_recursive($productFileTypes);

        $products = $this->makeProductCollection();

        $producttype = $product->producttype->displayName ;

        $productPhotos = $product->photos->sortBy("order") ;
        if($product->photos->isNotEmpty())
            $defaultProductPhotoOrder = $product->photos->sortByDesc("order")->first()->order + 1    ;
        else $defaultProductPhotoOrder = 0;

        return view("product.edit" , compact("product" , "amountLimit" , "defaultAmountLimit" , "enableStatus" , "defaultEnableStatus" , "attributesets", "bons" , "productFiles" , "productFileTypes"  , "products" , "defaultProductFileOrders" , "producttype" , "productPhotos" , "defaultProductPhotoOrder")) ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \app\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(EditProductRequest $request, $product)
    {
        $oldFile = $product->file;
        $oldImage = $product->image;

        $product->fill($request->all());

        if(strlen($request->get("introVideo"))>0)
            if(!preg_match("/^http:\/\//", $product->introVideo) && !preg_match("/^https:\/\//", $product->introVideo) )
                $product->introVideo = "https://". $product->introVideo ;

        if($request->has("changeChildrenPrice"))
            if($product->hasChildren())
            {
                foreach ($product->children as $child)
                {
                    $child->basePrice = $product->basePrice ;
                    $child->update();
                }
            }

        if ($request->hasFile("file")) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $fileName = basename($file->getClientOriginalName() , ".".$extension) . "_" . date("YmdHis") . '.' . $extension;
            if (Storage::disk(Config::get('constants.DISK5'))->put($fileName, File::get($file))) {
                Storage::disk(Config::get('constants.DISK5'))->delete($oldFile);
                $product->file = $fileName;
            }
        }

        if ($request->hasFile("image")) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileName = basename($file->getClientOriginalName() , ".".$extension) . "_" . date("YmdHis") . '.' . $extension;
            if (Storage::disk(Config::get('constants.DISK4'))->put($fileName, File::get($file))) {
                Storage::disk(Config::get('constants.DISK4'))->delete($oldImage);
                $product->image = $fileName;
//                $img = Image::make(Storage::disk(Config::get('constants.DISK4'))->getAdapter()->getPathPrefix().$fileName);
//                $img->resize(256, 256);
//                $img->save(Storage::disk(Config::get('constants.DISK4'))->getAdapter()->getPathPrefix().$fileName);
            }
        }

        if ($request->get('amountLimit') == 0){
            $product->amount = null;
        }

        $bon = Bon::where('id', $request->get('bon_id'))->first();
        if(strlen($request->get('bonPlus')) == 0) $bonPlus = 0; else $bonPlus = $request->get('bonPlus');
        if(strlen($request->get('bonDiscount')) == 0) $bonDiscount = 0; else $bonDiscount = $request->get('bonDiscount');

        if($bonPlus || $bonDiscount){
            $product->bons()->sync([$bon->id, ['discount' => $bonDiscount , 'bonPlus' => $bonPlus]]);
        }

        if($request->has("isFree")) $product->isFree = 1;
        else $product->isFree = 0;

        if(strlen(preg_replace('/\s+/', '', $product->discount)) == 0) $product->discount = 0;
        if(strlen(preg_replace('/\s+/', '', $product->shortDescription)) == 0) $product->shortDescription = null;
        if(strlen(preg_replace('/\s+/', '', $product->longDescription)) == 0) $product->longDescription = null;
        if(strlen(preg_replace('/\s+/', '', $product->specialDescription)) == 0) $product->specialDescription = null;

        if($request->has("order"))
        {
            if(strlen(preg_replace('/\s+/', '', $request->get("order"))) == 0) $product->order = 0;
            $productsWithSameOrder = Product::getProducts(0 , 1)->where("id" , "<>" , $product->id)->where("order" , $product->order)->get();
            if(!$productsWithSameOrder->isEmpty())
            {
                $productsWithGreaterOrder =  Product::getProducts(0 , 1)->where("id" , "<>" , $product->id)->where("order" ,">=" ,$product->order)->get();
                foreach ($productsWithGreaterOrder as $graterProduct)
                {
                    $graterProduct->order = $graterProduct->order + 1 ;
                    $graterProduct->update();
                }
            }
        }

        if ($product->update()) {
            session()->put('success', 'اصلاح محصول با موفقیت انجام شد');
        }
        else{
            session()->put('error', 'خطای پایگاه داده');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \app\Product $product
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($product)
    {
        if ($product->delete()) session()->put('success', 'محصول با موفقیت اصلاح شد');
        else session()->put('error', 'خطای پایگاه داده');
        return redirect()->back() ;
    }

    /**
     *
     *
     * @param \Illuminate\Http\Request $request
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function refreshPrice(Request $request, Product $product)
    {
        $productIds = $request->get("products");
        $inputType = $request->get("type");
        $attributevalues = $request->get("attributeState");
        $user = null ;
        if(session()->has("adminOrder_id"))
            $user = User::where("id" , session()->get("customer_id"))->first();
        elseif(Auth::check())
            $user = Auth::user();

        $key="product:refreshPrice:Type"
            .$inputType
            ."\\"
            .$product->cacheKey()
            ."-user"
            .( isset($user) && !is_null($user) ? $user->cacheKey() : "")
            ."\\attrValues:".( isset($attributevalues) ? implode("",$attributevalues) : "-")
            ."products:"
            .( isset($productIds) ? implode("",$productIds) : "");


        return Cache::tags('bon')->remember($key,  Config::get("constants.CACHE_60") , function () use($inputType,$attributevalues,$user,$product,$productIds){
            switch ($inputType)
            {
                case  "extraAttribute":
                    $totalExtraCost = 0;
                    if(isset($attributevalues)) {
                        foreach ($attributevalues as $attributevalueId) {

                            $attributevalue = $product->attributevalues->where("id", $attributevalueId)->first();
                            if (isset($attributevalue->pivot->extraCost))
                                $extraCost = $attributevalue->pivot->extraCost;
                            else
                                $extraCost = 0;
                            $totalExtraCost = $totalExtraCost + $extraCost;
                        }
                    }
                    $result =  json_encode(
                        [
                            'totalExtraCost' => $totalExtraCost
                        ]
                    );
                    break;
                case "mainAttribute":
                    if($product->hasChildren()) {
                        // find the child ( selected by user )
                        foreach ($product->children as $child) {
                            $childAttributevalues = $child->attributevalues;
                            $flag = true;
                            foreach ($attributevalues as $attributevalue) {
                                if (!$childAttributevalues->contains($attributevalue)) {
                                    $flag = false;
                                    break;
                                }
                            }
                            if ($flag && $childAttributevalues->count() == count($attributevalues)) {
                                $simpleProduct = $child;
                                break;
                            }
                        }
                    }else{

                        $simpleProduct = $product;
                    }
                    if(isset($simpleProduct) && (!isset($simpleProduct->quantity) || $simpleProduct->quantity>0))
                    {
                        if(isset($user))
                            $costArray = $simpleProduct->calculatePayablePrice($user );
                        else
                            $costArray = $simpleProduct->calculatePayablePrice( );
                        $cost = $costArray["cost"] ;
                        $costForCustomer = $costArray['CustomerCost'];
                        $result = json_encode(
                            [
                                "cost"=>$cost ,
                                "costForCustomer"=>$costForCustomer
                            ]
                        );
                    }
                    elseif(!isset($simpleProduct))
                    {
                        $result = json_encode(
                            [
                                'productWarning' => "محصول مورد نظر یافت نشد"
                            ]
                        );
                    }
                    else
                        $result = json_encode(
                            [
                                'productWarning' => "محصول مورد نظر تمام شده است"
                            ]
                        );
                    break;
                case "productSelection":

                    $cost = 0;
                    $costForCustomer = 0;
                    if(isset($productIds))
                    {
                        $productIds = Product::whereIn('id',$productIds)->get();
                        $productIds->load('parents');
                        foreach ($productIds as $key => $simpleProduct)
                        {
                            if($simpleProduct->hasParents())
                            {
                                if ($productIds->contains($simpleProduct->parents->first()))
                                {
                                    $productIds->forget($key);
                                    $childrenArray = $simpleProduct->children;
                                    foreach ($childrenArray as $child)
                                    {
                                        $ck = $productIds->search($child);
                                        $productIds->forget($ck);
                                    }
                                }
                            }
                        }
                        foreach ($productIds as $simpleProduct)
                        {
                            if(isset($user))
                                $costArray = $simpleProduct->calculatePayablePrice($user );
                            else
                                $costArray = $simpleProduct->calculatePayablePrice( );
                            $cost += $costArray["cost"] ;
                            $costForCustomer += $costArray["CustomerCost"];
                        }
                    }
                    $result = json_encode(
                        [
                            "cost"=>$cost ,
                            "costForCustomer"=> $costForCustomer
                        ]
                    );
                    break;
                default:
                    $result =[];
                    break;
            }
            return $result;
        });

    }

    /**
     * Search for a product
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        if (session()->has("adminOrder_id")) {
            $adminOrder = true;

        }
        else
            $adminOrder = false;

        $itemsPerPage = 16;
        if ($adminOrder) {
            $products =  Product::getProducts()->orderBy("order")->paginate($itemsPerPage);;
        } else {
            if (Config::has("constants.PRODUCT_SEARCH_EXCLUDED_PRODUCTS"))
                $excludedProducts = Config::get("constants.PRODUCT_SEARCH_EXCLUDED_PRODUCTS");
            else
                $excludedProducts = [];
            $products =  Product::getProducts(0, 1)->whereNotIn("id", $excludedProducts)->orderBy("order")->paginate($itemsPerPage);;
        }

        $costCollection = $this->makeCostCollection($products);

        $metaKeywords = "";
        $metaDescription = "" ;
        foreach ($products as $product)
        {
            $metaKeywords .= $product->name."-";
            $metaDescription .= $product->name."-" ;
        }
        $url = $request->url();
        SEO::opengraph()->setUrl($url);
        SEO::setCanonical($url);
        SEO::twitter()->setSite("آلاء");
        SEO::setTitle("محصولات ".$this->setting->site->name);
        SEO::setDescription($metaDescription);
        SEO::opengraph()->addImage(route('image', ['category'=>'11','w'=>'100' , 'h'=>'100' ,  'filename' =>  $this->setting->site->siteLogo ]), ['height' => 100, 'width' => 100]);
        SEO::opengraph()->setType('website');

        return view("product.portfolio" , compact("products" , "costCollection")) ;
    }

    /**
     * enable or disable children of product
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \app\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function childProductEnable(Request $request , $product){
        $parent = $product->parents->first();
        if($product->enable == 1) {
            $product->enable = 0;
            foreach ($product->attributevalues as $attributevalue) {
                $flag = 0;
                $children = $parent->children->where("id","!=" , $product->id)->where("enable" , 1);
                foreach ($children as $child) {
                    if ($child->attributevalues->contains($attributevalue) == true) {
                        $flag = 1;
                        break;
                    }
                }
                if ($flag == 0)  $parent->attributevalues()->detach($attributevalue);
            }
        }
        elseif ($product->enable == 0){
            $product->enable = 1;
            foreach ($product->attributevalues as $attributevalue) {
                if($parent->attributevalues->contains($attributevalue) == false) {
                    if(isset($attributevalue->pivot->extraCost) && $attributevalue->pivot->extraCost>0) $attributevalueDescription = "+".number_format($attributevalue->pivot->extraCost)."تومان";
                    else $attributevalueDescription = null ;
                    $parent->attributevalues()->attach($attributevalue->id,["description"=> $attributevalueDescription]);
                }
            }
        }
        if ($product->update()) {
            session()->put('success', 'وضعیت فرزند محصول با موفقیت تغییر کرد');
        }
        else{
            session()->put('error', 'خطای پایگاه داده');
        }
        return redirect()->back();
    }

    /**
     * Show the form for configure the specified resource.
     *
     * @param  \app\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function createConfiguration($product){
            $attributeCollection = collect();
            $attributeGroups = $product->attributeset->attributeGroups ;
            foreach ($attributeGroups as $attributeGroup)
            {
                $attributeType = Attributetype::where("name" , "main")->get()->first() ;
                $attributes = $product->attributeset->attributes()->where("attributetype_id" , $attributeType->id);
                foreach ($attributes as $attribute)
                {
                    $attributeValues = $attribute->attributevalues ;
                    $attributeValuesCollect = collect();
                    foreach ($attributeValues as $attributeValue)
                    {
                        $attributeValuesCollect->push($attributeValue);
//                        array_push($attributeValuesArray , $attributeValue);
                    }
                    $attributeCollection->push( ["attribute"=>$attribute , "attributeControl"=>$attribute->attributecontrol->name , "attributevalues"=>$attributeValuesCollect]);
                }
            }
            return view("product.configureProduct.createConfiguration" , compact("product" , "attributeCollection"));
    }

    /**
     * make children for product
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \app\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function makeConfiguration(Request $request, $product){

        $matrix = [];
        $array = [] ; // checkbox attribute values

        //attach attributevalues that are chosen for the product
//        foreach ($product->attributeset->attributegroups as $attributegroup)
//        {
//            $i = 0;
//            foreach ($attributegroup->attributes as $attribute){
//                if(isset($request->all()[$attribute->id])){
//                    $j = 0;
//                    foreach ($request->all()[$attribute->id] as $value){
//                        $attributevalue = Attributevalue::findOrFail($value);
//                        $product->attributevalues()->attach($attributevalue);
//                        $matrix[$i][$j] = $attributevalue->id;
//                        $j++;
//                    }
//                    $i++;
//                }
//            }
//        }
        $attributeIds = $request->get("attributevalues");
        $extraCosts = $request->get("extraCost");
        $orders = $request->get("order");
        $descriptions = $request->get("description");
        $i = 0;
        foreach ($attributeIds as $attributeId)
        {
            $j = 0 ;
            foreach ($attributeId as $attributevalueId)
            {
                $extraCost = $extraCosts[$attributevalueId];
                if(!isset($extraCost[0])) $extraCost = 0;

                $order = $orders[$attributevalueId];
                if(!isset($order[0])) $order = 0;

                $description = $descriptions[$attributevalueId] ;
                if(!isset($description[0])) $description = null;

                $attributevalue = Attributevalue::findOrFail($attributevalueId );
                $product->attributevalues()->attach($attributevalue, ["extraCost"=>$extraCost , "order"=>$order, "description"=>$description]);
                if(strcmp($attributevalue->attribute->attributecontrol->name , "groupedCheckbox") == 0)
                {
                    array_push($array,$attributevalue->id);
                }else{
                    $matrix[$i][$j] = $attributevalue->id;
                    $j++;
                }
            }
            $i++;
        }

        if(sizeof($matrix) == 0) return redirect()->back();
        if(sizeof($matrix) == 1) $productConfigurations = current($matrix);
        elseif(sizeof($matrix) >= 2) {
            $vertex = array_pop($matrix);
            $productConfigurations =  $this->cartesianProduct($matrix, $vertex)[0];
        }

        foreach ($array as $item){
            foreach ($productConfigurations as $productConfig)
            {
                $newProductConfig = $productConfig . ",".$item;
                array_push($productConfigurations , $newProductConfig) ;
            }
        }

        foreach ($productConfigurations as $productConfig) {
            $childProduct = $product->replicate();
            $childProduct->order = 0 ;
            $attributevalueIds = explode(",", $productConfig);
            $productName = "";
            $attributevalues = [];
            foreach ($attributevalueIds as $attributevalueId) {
                $attributevalue = Attributevalue::findOrFail($attributevalueId);
                array_push($attributevalues, $attributevalue);
                $productName = $productName . "-" . $attributevalue->name;
            }
            $childProduct->name = $product->name . $productName;
            $childProduct->producttype_id = 1;
            if ($childProduct->save()) {
                $childProduct->parents()->attach($product);
                foreach ($attributevalues as $attributevalue) {

                    $extraCost = $extraCosts[$attributevalue->id];
                    if(!isset($extraCost[0])) $extraCost = 0;

                    $order = $orders[$attributevalue->id];
                    if(!isset($order[0])) $order = 0;

                    $description = $descriptions[$attributevalue->id] ;
                    if(!isset($description[0])) $description = null;

                    $childProduct->attributevalues()->attach($attributevalue, ["extraCost"=>$extraCost , "order"=>$order, "description"=>$description]);
                }

            } else {
                session()->put('error', 'خطای پایگاه داده');
            }
        }
        return redirect(action("ProductController@edit", $product));
    }

    /**
     * make cartesian product
     *
     * @param  $matrix
     * @param  $vertex
     * @return $result
     */
    function cartesianProduct($matrix, $vertex){
        if(sizeof($matrix) == 0) {$result[0][0] = $vertex; return $result;}
        elseif(sizeof($matrix) == 1) {
            $result = [];
            $index = 0;
            foreach (current($matrix) as $firstItem) {
                foreach ($vertex as $secondItem) {
                    $result[0][$index] = $firstItem.",".$secondItem;
                    $index++;
                }
            }
            return $result;
        }
        elseif(sizeof($matrix) >= 2){
            $vertex2 = array_pop($matrix);
            return $this->cartesianProduct($this->cartesianProduct($matrix, $vertex2), $vertex);
        }
    }

    /**
     * Show the form for setting pivots for attributevalues
     *
     * @param  \app\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function editAttributevalues($product)
    {

        $attributeValuesCollection = collect() ;

       $attributeset = $product->attributeset;
       $attributeGroups = $attributeset->attributegroups;
       foreach ($attributeGroups as $attributeGroup)
       {
           $attributes = $attributeGroup->attributes->sortBy("order");
           foreach ($attributes as $attribute)
           {
               $type = Attributetype::FindOrFail($attribute->attributetype_id);
               $productAttributevlues = $product->attributevalues->where("attribute_id" , $attribute->id);
               $attrributevalues = $attribute->attributevalues;
               if(!isset($attributeValuesCollection[$type->id])) $attributeValuesCollection->put($type->id,collect(["name"=>$type->name,"displayName"=>$type->description , "attributes"=>[]]));
               $helperCollection = collect($attributeValuesCollection[$type->id]["attributes"]);
               $helperCollection->push(["name"=>$attribute->displayName,"type"=>$type , "values"=>$attrributevalues , "productAttributevalues"=>$productAttributevlues ]);
               $attributeValuesCollection[$type->id]->put("attributes",$helperCollection);
           }
       }
        return view('product.configureProduct.editAttributevalues', compact('product' ,'attributeValuesCollection'));
    }

    /**
     * set pivot for attributevalues
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \app\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function updateAttributevalues(Request $request, $product){
        dd($request->all());
        $product->attributevalues()->detach($product->attributevalues->pluck("id")->toArray()) ;
        $newAttributevalues = $request->get("attributevalues");
        $newExtraCost = $request->get("extraCost");
        $newDescription = $request->get("description");
        foreach ($newAttributevalues as $attributevalueId){
            $extraCost = $newExtraCost[$attributevalueId];
            if(strlen($extraCost) == 0) $extraCost = null;
            $description = $newDescription[$attributevalueId];
            if(strlen($extraCost) == 0) $extraCost = null;
            if($product->attributevalues()->attach($attributevalueId ,["extraCost" => $extraCost, "description" => $description])){
                $children =  $product->children()->whereHas("attributevalues" , function ($q) use ($attributevalueId){
                    $q->where("id" , $attributevalueId);
                })->get();
                foreach ($children as $child){
                        $child->attributevalues()->where("id",$attributevalueId)->updateExistingPivot($attributevalueId ,["extraCost" => $extraCost, "description" => $description]);
                }
            }
        }
        return redirect(action("ProductController@edit", $product));
    }

    /**
     * Show live view page for this product(In case it has one!)
     *
     * @return \Illuminate\Http\Response
     */
    public function showLive(Product $product){
        return redirect(action("ProductController@show" , $product));
    }

    /**
     * Attach a complimentary product to a product
     *
     * @param \App\Product $product
     * @param \App\Http\Requests\AddComplimentaryProductRequest $request
     * @return \Illuminate\Http\Response
     */
    public function addComplimentary(AddComplimentaryProductRequest $request , $product){
        $complimentary = Product::findOrFail($request->get("complimentaryproducts"));

        if($product->complimentaryproducts->contains($complimentary))
        {
            session()->put('error', 'این اشانتیون قبلا درج شده است');
        }
        else
        {
            $product->complimentaryproducts()->attach($complimentary);
            session()->put('success', 'درج اشانتیون با موفقیت انجام شد');
        }
        return redirect()->back();
    }

    /**
     * Detach a complimentary product to a product
     *
     * @param \App\Product $complimentary
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function removeComplimentary(Request $request,Product $complimentary){
        $product = Product::findOrFail($request->get("productId"));
        $product->complimentaryproducts()->detach($complimentary);
        session()->put('success', 'حذف اشانتیون با موفقیت انجام شد');
        return $this->response->setStatusCode(200);
    }

    /**
     * Attach a gift product to a product
     *
     * @param \App\Product $product
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addGift(Request $request , $product){
        $gift = Product::findOrFail($request->get("giftProducts"));

        if($product->gifts->contains($gift))
        {
            session()->put('error', 'این هدیه قبلا به این محصول اضافه شده است');
        }
        else
        {
            $product->gifts()->attach($gift, ["relationtype_id"=>Config::get("constants.PRODUCT_INTERRELATION_GIFT")]);
            session()->put('success', 'هدیه با موفقیت به محصول اضافه شد');
        }
        return redirect()->back();
    }

    /**
     * Detach a gift product to a product
     *
     * @param \App\Product $product
     * @param \App\Product $gift
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function removeGift(Request $request , Product $product)
    {
        $gift = Product::where("id" ,    $request->get("giftId"))->get()->first();
        if(!isset($gift)) return $this->response->setStatusCode(503)->setContent(["message"=>"خطا! چنین محصول هدیه ای وجود ندارد"]);

        if($product->gifts()->detach($gift->id))
            return $this->response->setStatusCode(200)->setContent(["message"=>"هدیه با موفقیت حذف شد"]);
        else
            return $this->response->setStatusCode(503)->setContent(["message"=>"خطا در حذف هدیه . لطفا دوباره اقدام نمایید"]);
    }

    /**
     * Products Special Landing Page
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function landing1(Request $request)
    {
        $url = $request->url();
        SEO::opengraph()->setUrl($url);
        SEO::setCanonical($url);
        SEO::twitter()->setSite("آلاء");
        SEO::setTitle("آلاء| جمع بندی نیم سال اول");
        SEO::setDescription("همایش ویژه دی ماه آلاء حمع بندی کنکور اساتید آلاء تست درسنامه تخفیف");
        SEO::opengraph()->addImage(route('image', ['category'=>'11','w'=>'100' , 'h'=>'100' ,  'filename' =>  $this->setting->site->siteLogo ]), ['height' => 100, 'width' => 100]);
        SEO::opengraph()->setType('website');

        $productIds = Config::get("constants.HAMAYESH_PRODUCT");
        $products = Product::whereIn("id" , $productIds)->orderBy("order")->where("enable" , 1)->get();
        $attribute = Attribute::where("name" , "major")->get()->first();
        $withFilter = true;

        $landingProducts = collect();
        foreach ($products as $product)
        {
            $majors = [];
            if(isset($attribute))
            {
                $majors = $product->attributevalues->where("attribute_id" , $attribute->id)->pluck("name")->toArray();
            }

            $landingProducts->push(["product"=>$product , "majors"=>$majors]);
        }

        $costCollection = $this->makeCostCollection($products) ;
        return view("product.landing.landing1" , compact("landingProducts" , "costCollection" , "withFilter" ));
    }

    /**
    * Products Special Landing Page
    *
    * @return \Illuminate\Http\Response
    */
    public function landing2()
    {
        return redirect("/landing/4",302);
        $gheireHozoori = Config::get("constants.ORDOO_GHEIRE_HOZOORI_NOROOZ_97_PRODUCT_ALLTOGHETHER") ;
        if(Input::has("utm_term"))
        {
            $utm_term = Input::get("utm_term");
            switch ($utm_term)
            {
                case "700":
                    $gheireHozoori = Config::get("constants.ORDOO_GHEIRE_HOZOORI_NOROOZ_97_PRODUCT_ALLTOGHETHER");
                    break;
                case "260":
                    $gheireHozoori = Config::get("constants.ORDOO_GHEIRE_HOZOORI_NOROOZ_97_PRODUCT_DEFAULT");
                    break;
                default:
                    break;
            }
        }

        $products = Product::whereIn("id" , Config::get("constants.ORDOO_GHEIRE_HOZOORI_NOROOZ_97_PRODUCT"))->orwhereIn("id" , Config::get("constants.ORDOO_HOZOORI_NOROOZ_97_PRODUCT"))->orderBy("order")->where("enable" , 1)->get();

        $landingProducts = collect();
        foreach ($products as $product)
        {
            $landingProducts->push(["product"=>$product]);
        }
        $costCollection = $this->makeCostCollection($products) ;
        return view("product.landing.landing2" , compact("landingProducts" , "costCollection" , "utm_term" , "gheireHozoori" ));
    }

    /**
     * Products Special Landing Page
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function landing3(Request $request)
    {
        $url = $request->url();
        SEO::opengraph()->setUrl($url);
        SEO::setCanonical($url);
        SEO::twitter()->setSite("آلاء");
        SEO::setTitle("آلاء | همایش های طلایی کنکور 97");
        SEO::setDescription("وقتی همه کنکوری ها گیج و سرگردانند، شما مرور کنید. چالشی ترین نکات کنکوری در همایش های آلاء");
        SEO::opengraph()->addImage(route('image', ['category'=>'11','w'=>'100' , 'h'=>'100' ,  'filename' =>  $this->setting->site->siteLogo ]), ['height' => 100, 'width' => 100]);
        SEO::opengraph()->setType('website');
        return view("product.landing.landing3" );
    }

    /**
     * Products Special Landing Page
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function landing4(Request $request)
    {
        $url = $request->url();
        SEO::opengraph()->setUrl($url);
        SEO::setCanonical($url);
        SEO::twitter()->setSite("آلاء");
        SEO::setTitle("آلاء | همایش های طلایی کنکور 97");
        SEO::setDescription("وقتی همه کنکوری ها گیج و سرگردانند، شما مرور کنید. چالشی ترین نکات کنکوری در همایش های آلاء");
        SEO::opengraph()->addImage(route('image', ['category'=>'11','w'=>'100' , 'h'=>'100' ,  'filename' =>  $this->setting->site->siteLogo ]), ['height' => 100, 'width' => 100]);
        SEO::opengraph()->setType('website');

        return view("product.landing.landing4" );
    }

    /**
     * Copy a product completely
     *
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function copy(Product $product)
    {
        $newProduct = $product->replicate();
        $correspondenceArray = array();
        $done = true;
        if($newProduct->save())
        {
            /**
             * Copying children
             */
            if($product->hasChildren())
            {
                foreach ($product->children as $child)
                {
                    $response = $this->copy($child);
                    if($response->getStatusCode() == 200)
                    {
                        $response = json_decode($response->getContent());
                        $newChildId = $response->newProductId;
                        if(isset($newChildId)) {
                              $correspondenceArray[$child->id] = $newChildId;
                              $newProduct->children()->attach($newChildId);
                        }else{
                            $done = false;
                        }
                    }else{
                        $done = false;
                    }
                }
            }

            /**
             * Copying attributeValues
             */
            foreach ($product->attributevalues as $attributevalue)
            {
                $newProduct->attributevalues()->attach($attributevalue->id , ["extraCost"=>$attributevalue->pivot->extraCost , "description"=>$attributevalue->pivot->description]);
            }

            /**
             * Copying bons
             */
            foreach ($product->bons as $bon)
            {
                $newProduct->bons()->attach($bon->id , ["discount"=>$bon->pivot->discount , "bonPlus"=>$bon->pivot->bonPlus]) ;
            }

            /**
             * Copying coupons
             */
            $newProduct->coupons()->attach($product->coupons->pluck('id')->toArray()) ;

            /**
             * Copying complimentary
             */
            foreach ($product->complimentaryproducts as $complimentaryproduct)
            {
                $flag = $this->haveSameFamily(collect([$product , $complimentaryproduct]));
                if(!$flag)
                {
                    $newProduct->complimentaryproducts()->attach($complimentaryproduct->id);
                }

            }

            /**
             * Copying gifts
             */
            foreach ($product->gifts as $gift)
            {
                $flag = $this->haveSameFamily(collect([$product , $gift]));
                if(!$flag)
                {
                        $newProduct->gifts()->attach($gift->id , ["relationtype_id"=>Config::get("constants.PRODUCT_INTERRELATION_GIFT")]);
                }
            }

            if($product->hasChildren())
            {
                $children = $product->children ;
                foreach ($children as $child)
                {
                    $childComplementarities = $child->complimentaryproducts ;
                    $intersects = $childComplementarities->intersect($children) ;
                    foreach ($intersects as $intersect)
                    {
                        $correspondingChild = Product::where("id" , $correspondenceArray[$child->id])->get()->first() ;
                        $correspondingComplimentary = $correspondenceArray[$intersect->id];
                        $correspondingChild->complimentaryproducts()->attach($correspondingComplimentary) ;
                    }
                }
            }

            if($done == false){
                foreach ($newProduct->children as $child)
                {
                    $child->forceDelete();
                }
                $newProduct->forceDelete();
                return $this->response->setStatusCode(503)->setContent(["message"=>"خطا در کپی از الجاقی محصول . لطفا دوباره اقدام نمایید"]);
            }else
            {
                return $this->response->setStatusCode(200)->setContent(["message"=>"عملیات کپی با موفقیت انجام شد." , "newProductId"=>$newProduct->id]);
            }
        }else{
            return $this->response->setStatusCode(503)->setContent(["message"=>"خطا در کپی از اطلاعات پایه ای محصول . لطفا دوباره اقدام نمایید"]);
        }
    }
}
