<?php

namespace App\Http\Controllers;

use App\{Attribute,
    Attributeset,
    Attributetype,
    Attributevalue,
    Bon,
    Classes\Search\ProductSearch,
    Classes\SEO\SeoDummyTags,
    Http\Requests\AddComplimentaryProductRequest,
    Http\Requests\EditProductRequest,
    Http\Requests\InsertProductRequest,
    Http\Requests\ProductIndexRequest,
    Product,
    Productfiletype,
    Traits\CharacterCommon,
    Traits\Helper,
    Traits\MathCommon,
    Traits\MetaCommon,
    Traits\ProductCommon,
    Traits\RequestCommon,
    Traits\SearchCommon,
    User,
    Websitesetting};
use Illuminate\Foundation\Http\{FormRequest};
use Illuminate\Http\{Request, Response};
use Illuminate\Support\{Collection, Facades\Cache, Facades\File, Facades\Input, Facades\Storage, Facades\View};

class ProductController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Traits
    |--------------------------------------------------------------------------
    */

    use Helper;
    use ProductCommon;
    use MetaCommon;
    use MathCommon;
    use CharacterCommon;
    use RequestCommon;
    use SearchCommon ;


    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    const PARTIAL_SEARCH_TEMPLATE = 'partials.search.product';
    const PARTIAL_INDEX_TEMPLATE  = 'product.index';
    protected $response;
    protected $setting;

    /*
    |--------------------------------------------------------------------------
    | Private methods
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | Private methods
    |--------------------------------------------------------------------------
    */

    function __construct(Response $response, Websitesetting $setting)
    {
        $this->response = $response;
        $this->setting = $setting->setting;
        $this->callMiddlewares();
    }

    private function callMiddlewares(): void
    {
        //        $this->middleware('permission:' . config('constants.LIST_PRODUCT_ACCESS'), ['only' => 'index']);
        $this->middleware('permission:' . config('constants.INSERT_PRODUCT_ACCESS'), ['only' => 'create']);
        $this->middleware('permission:' . config('constants.REMOVE_PRODUCT_ACCESS'), ['only' => 'destroy']);
        $this->middleware('permission:' . config('constants.SHOW_PRODUCT_ACCESS'), ['only' => 'edit']);
        $this->middleware('permission:' . config('constants.EDIT_PRODUCT_ACCESS'), ['only' => 'update']);
        $this->middleware('permission:' . config('constants.EDIT_CONFIGURE_PRODUCT_ACCESS'), [
            'only' => [
                'childProductEnable',
                'completeEachChildPivot',
            ],
        ]);
        $this->middleware('permission:' . config('constants.INSERT_CONFIGURE_PRODUCT_ACCESS'), [
            'only' => 'makeConfiguration',
            'createConfiguration',
        ]);
        $this->middleware('auth', [
            'except' => [
                'index',
                'show',
                'refreshPrice',
                'search',
                'showPartial',
                'landing1',
                'landing2',
                'landing3',
                'landing4',
            ],
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param ProductIndexRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductIndexRequest $request)
    {
        $tags = $request->get('tags');
        $filters = $request->all();
        $isApp = $this->isRequestFromApp($request);
        $items = collect();
        $pageName = 'productPage';
        $productResult = (new ProductSearch)->setPageName($pageName)
                                            ->apply($filters);
        //        dd($productResult->where('enable','=',0));
        if ($isApp) {
            $items->push($productResult->getCollection());
        } else {
            if ($productResult->total() > 0) {
                //                $partialSearch = View::make('product.index', ['products' => $productResult])->render();
                $partialSearch = $this->getPartialSearchFromIds($productResult, self::PARTIAL_SEARCH_TEMPLATE);
                $partialIndex = $this->getPartialSearchFromIds($productResult, self::PARTIAL_INDEX_TEMPLATE);
            } else {
                $partialSearch = null;
                $partialIndex = null;
            }
            $items->push([
                             "totalitems" => $productResult->total(),
                             "view"       => $partialSearch,
                             "indexView"  => $partialIndex,
                         ]);
        }

        if ($isApp) {
            $response = $this->makeJsonForAndroidApp($items);
            return response()->json($response, Response::HTTP_OK);
        }
        if (request()->ajax()) {
            return $this->response->setStatusCode(Response::HTTP_OK)
                                  ->setContent([
                                                   "items"     => $items,
                                                   "tagLabels" => $tags,
                                               ]);
        }
        //        if (session()->has("adminOrder_id"))
        //            $adminOrder = true;
        //        else
        //            $adminOrder = false;

        //        if ($adminOrder)
        //        {
        //            $itemsPerPage = 30;
        //            $products =  Product::getProducts(0,0,[],"order")->paginate($itemsPerPage);
        //        } else {
        //            if (config()->has("constants.PRODUCT_SEARCH_EXCLUDED_PRODUCTS"))
        //                $excludedProducts = config("constants.PRODUCT_SEARCH_EXCLUDED_PRODUCTS");
        //            else
        //                $excludedProducts = [];
        //        }

        $products = $productResult;
        $costCollection = $this->makeCostCollection($products);

        $url = $request->url();
        $this->generateSeoMetaTags(new SeoDummyTags("محصولات " . $this->setting->site->name, 'کارگاه تست کنکور، همایش، جمع بندی و اردوطلایی نوروز آلاء', $url, $url, route('image', [
            'category' => '11',
            'w'        => '100',
            'h'        => '100',
            'filename' => $this->setting->site->siteLogo,
        ]), '100', '100', null));

        return view("product.portfolio", compact("products", "costCollection"));
    }

    /**
     * @param Collection $items
     *
     * @return \Illuminate\Http\Response
     */
    private function makeJsonForAndroidApp(Collection $items)
    {
        $items = $items->pop();
        $key = md5($items->pluck("id")
                         ->implode(","));
        $response = Cache::remember($key, config("constants.CACHE_60"), function () use ($items) {
            $response = collect();

        });
        return $response;
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
     * @param InsertProductRequest $request
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function store(InsertProductRequest $request)
    {
        $product = new Product();

        if ($this->strIsEmpty($request->get('bonPlus')))
            $bonPlus = 0; else
            $bonPlus = $request->get('bonPlus');

        if ($this->strIsEmpty($request->get('bonDiscount')))
            $bonDiscount = 0; else
            $bonDiscount = $request->get('bonDiscount');
        $bonId = $request->get('bon_id');

        $this->fillProductFromRequest($request, $product);

        if ($product->save()) {
            if ($bonPlus || $bonDiscount)
                $this->attachBonToProduct($product, $bonId, $bonDiscount, $bonPlus);
            return $this->response->setStatusCode(Response::HTTP_OK);
        } else {
            return $this->response->setStatusCode(Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }

    /**
     * @param FormRequest $request
     * @param Product     $product
     *
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function fillProductFromRequest(FormRequest $request, Product &$product): void
    {
        $inputData = $request->all();
        $files = $request->has("files")?[$request->files]:[];
        $images = $request->has("image")?[$request->image]:[];
        $isFree = $request->has("isFree");

        $product->fill($inputData);

        $product->isFree = $isFree;
        if (!$this->strIsEmpty($product->introVideo))
            $this->makeValidUrl($product->introVideo);
        //Storing product's catalog
        $storeFileResult = $this->storeCatalogOfProduct($product, $files);
        //ToDo : delete the file if it is an update

        //Storing product's image
        $storeImageResult = $this->storeImageOfProduct($product, $images);
        //ToDo : delete the file if it is an update
    }

    /** Stores catalog file of the product
     *
     * @param Product $product
     *
     * @param array   $files
     *
     * @return array
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function storeCatalogOfProduct(Product &$product, array $files): array
    {
        $done = [];
        foreach ($files as $key => $file) {
            $extension = $file->getClientOriginalExtension();
            $fileName = basename($file->getClientOriginalName(), "." . $extension) . "_" . date("YmdHis") . '.' . $extension;
            $done[$key] = false;
            if (Storage::disk(config('constants.DISK5'))
                       ->put($fileName, File::get($file))) {
                $product->file = $fileName;
                $done[$key] = true;
            }
        }

        return $done;
    }

    /** Stores image file of the product
     *
     * @param Product $product
     *
     * @param array   $files
     *
     * @return array
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function storeImageOfProduct(Product &$product, array $files): array
    {
        $done = [];
        foreach ($files as $key => $file) {
            $extension = $file->getClientOriginalExtension();
            $fileName = basename($file->getClientOriginalName(), "." . $extension) . "_" . date("YmdHis") . '.' . $extension;
            $done[$key] = false;
            if (Storage::disk(config('constants.DISK4'))
                       ->put($fileName, File::get($file))) {
                $done[$key] = true;
                $product->image = $fileName;

                /**
                 *  Snippet code : resizing the image using the ........ package
                 *
                 * $img = Image::make(Storage::disk(config('constants.DISK4'))->getAdapter()->getPathPrefix().$fileName);
                 * $img->resize(256, 256);
                 * $img->save(Storage::disk(config('constants.DISK4'))->getAdapter()->getPathPrefix().$fileName);
                 * */
            }
        }

        return $done;
    }

    /*
    |--------------------------------------------------------------------------
    | Public methods
    |--------------------------------------------------------------------------
    */

    /**
     * @param $product
     * @param $bonId
     * @param $bonDiscount
     * @param $bonPlus
     */
    private function attachBonToProduct(Product $product, $bonId, $bonDiscount, $bonPlus): void
    {
        $product->bons()
                ->attach($bonId, [
                    'discount' => $bonDiscount,
                    'bonPlus'  => $bonPlus,
                ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Request       $request
     * @param  \App\Product $product
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Product $product)
    {
        if(isset($product->redirectUrl))
            return redirect($product->redirectUrl, 301);

        $this->generateSeoMetaTags($product);

        $descriptionIframe = $request->partial;
        $productType = $product->producttype->id;

        $allAttributeCollection = $product->getAllAttributes();
        $this->addSimpleInfoAttributes($product); // ToDo : $product["simpleInfoAttributes"] has not been used
        $selectCollection = $allAttributeCollection["selectCollection"];
        $groupedCheckboxCollection = $allAttributeCollection["groupedCheckboxCollection"];
        $extraSelectCollection = $allAttributeCollection["extraSelectCollection"];
        $extraCheckboxCollection = $allAttributeCollection["extraCheckboxCollection"];
        $simpleInfoAttributes = $allAttributeCollection["simpleInfoAttributes"];
        $checkboxInfoAttributes = $allAttributeCollection["checkboxInfoAttributes"];

        $otherProductChunks = $this->makeOtherProducts($product, 4);

        $productSeenCount = $product->pageView;

        $productAllFiles = $this->makeAllFileCollection($product);

        $productSamplePhotos = $product->getPhotos();

        $giftCollection = $product->getGifts();


        return view("product.show", compact("product",
                                            "productType",
                                            "productSeenCount",
                                            "otherProductChunks",
                                            "selectCollection",
                                            "simpleInfoAttributes",
                                            "checkboxInfoAttributes",
                                            "extraSelectCollection",
                                            "extraCheckboxCollection",
                                            'groupedCheckboxCollection',
                                            "descriptionIframe",
                                            "productAllFiles",
                                            "exclusiveOtherProducts",
                                            "productSamplePhotos",
                                            "giftCollection"
        ));
    }

    /**
     * @param Product $product
     */
    private function addSimpleInfoAttributes(Product &$product)
    {
        $productsArray = [];
        array_push($productsArray, $product);

        while (count($productsArray)) {
            $pop = array_pop($productsArray);
            if (!isset($pop['simpleInfoAttributes'])) {
                $allAttributeCollection = $pop->getAllAttributes();
                $pop['simpleInfoAttributes'] = $allAttributeCollection["simpleInfoAttributes"];
            }
            foreach ($pop->children as &$p) {
                array_push($productsArray, $p);
            }
        }
    }

    /**
     * Display partial information of the specified resource.
     *
     * @param  \App\Product $product
     *
     * @return \Illuminate\Http\Response
     */
    public function showPartial(Product $product)
    {
        return redirect(action("ProductController@show", $product) . "?partial=true");
    }

    /**
     * Show live view page for this product(In case it has one!)
     *
     * @param Product $product
     *
     * @return \Illuminate\Http\Response
     */
    public function showLive(Product $product)
    {
        return redirect(action("ProductController@show", $product));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \app\Product $product
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($product)
    {
        $bonName = config("constants.BON1");
        $amountLimit = Product::AMOUNT_LIMIT;
        $defaultProductPhotoOrder = 0;
        $defaultAmountLimit = 0;
        $defaultEnableStatus = 0;
        $enableStatus = Product::ENABLE_STATUS;

        if ($product->isLimited())
            $defaultAmountLimit = 1;

        if ($product->enable)
            $defaultEnableStatus = 1;

        $attributesets = Attributeset::pluck('name', 'id')
                                     ->toArray();

        $bons = $product->bons();
        $bons->enable();
        $bons->ofName($bonName);
        $bons = $bons->get()
                     ->first();

        if (!isset($bons))
            $bons = Bon::ofName($bonName)
                       ->first();

        $productFiles = $product->productfiles->sortBy("order");
        $defaultProductFileOrders = $product->productFileTypesOrder();

        $productFileTypes = Productfiletype::makeSelectArray();

        $products = $this->makeProductCollection();

        $producttype = $product->producttype->displayName;

        $productPhotos = $product->photos->sortByDesc("order");
        if ($productPhotos->isNotEmpty())
            $defaultProductPhotoOrder = $productPhotos->first()->order + 1;

        return view("product.edit", compact("product", "amountLimit", "defaultAmountLimit", "enableStatus", "defaultEnableStatus", "attributesets", "bons", "productFiles", "productFileTypes", "defaultProductFileOrders", "products", "producttype", "productPhotos", "defaultProductPhotoOrder"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EditProductRequest $request
     * @param  \app\Product      $product
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function update(EditProductRequest $request, Product $product)
    {
        $bonId = $request->get('bon_id');
        if ($this->strIsEmpty($request->get('bonPlus')))
            $bonPlus = 0; else
            $bonPlus = $request->get('bonPlus');

        if ($this->strIsEmpty($request->get('bonDiscount')))
            $bonDiscount = 0; else
            $bonDiscount = $request->get('bonDiscount');
        $childrenPriceEqualizer = $request->has("changeChildrenPrice");


        $this->fillProductFromRequest($request, $product);

        if ($childrenPriceEqualizer)
            $product->equalizingChildrenPrice();

        if ($bonPlus || $bonDiscount)
            $this->attachBonToProduct($product, $bonId, $bonDiscount, $bonPlus);

        if ($product->update())
            session()->put('success', 'اصلاح محصول با موفقیت انجام شد'); else
            session()->put('error', 'خطای پایگاه داده');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request      $request
     * @param  \app\Product $product
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, Product $product)
    {
        $done = false;
        if ($product->delete())
            $done = true;

        if ($request->ajax()) {
            if ($done)
                return $this->response->setStatusCode(Response::HTTP_OK); else
                return $this->response->setStatusCode(Response::HTTP_SERVICE_UNAVAILABLE);
        } else {
            if ($done)
                session()->put('success', 'محصول با موفقیت اصلاح شد'); else
                session()->put('error', 'خطای پایگاه داده');

            return redirect()->back();
        }
    }

    /**
     *
     *
     * @param \Illuminate\Http\Request $request
     * @param Product                  $product
     *
     * @return \Illuminate\Http\Response
     */
    public function refreshPrice(Request $request, Product $product)
    {

        $mainAttributeValues = $request->get("mainAttributeValues");
        $selectedSubProductIds = $request->get("products");
        $extraAttributeValues = $request->get("extraAttributeValues");
        $user = $this->getCustomer($request);
        //        return (new AlaaProductPriceCalculator($product,$user))->getPrice();

        $key = "product:refreshPrice:Product"
            . "\\"
            . $product->cacheKey()
            . "-user"
            . (isset($user) && !is_null($user) ? $user->cacheKey() : "")
            . "\\mainAttributeValues:"
            . (isset($mainAttributeValues) ? implode("", $mainAttributeValues) : "-")
            . "\\subProducts:"
            . (isset($selectedSubProductIds) ? implode("", $selectedSubProductIds) : "-")
            . "\\extraAttributeValues:"
            . (isset($extraAttributeValues) ? implode("", $extraAttributeValues) : "-");

        return Cache::tags('bon')
                    ->remember($key, config("constants.CACHE_60"), function () use ($product, $user, $mainAttributeValues, $selectedSubProductIds, $extraAttributeValues) {
                        $productType = optional($product->producttype)->id;
                        $intendedProducts = collect();
                        switch ($productType) {
                            case config("constants.PRODUCT_TYPE_SIMPLE"):
                                $intendedProducts->push($product);
                                break;
                            case config("constants.PRODUCT_TYPE_CONFIGURABLE"):
                                $simpleProduct = $this->findProductChildViaAttributes($product, $mainAttributeValues);
                                if (isset($simpleProduct)) {
                                    $intendedProducts->push($simpleProduct);
                                }

                                break;
                            case config("constants.PRODUCT_TYPE_SELECTABLE"):
                                if (isset($selectedSubProductIds)) {
                                    $selectedSubProducts = Product::whereIn('id', $selectedSubProductIds)
                                                                  ->get();
                                    $selectedSubProducts->load('parents');
                                    $selectedSubProducts->keepOnlyParents();

                                    $intendedProducts = $selectedSubProducts;
                                }
                                break;
                            default :
                                break;
                        }

                        $cost = 0;
                        $costForCustomer = 0;
                        foreach ($intendedProducts as $product) {
                            if ($product->isInStock()) {
                                if (isset($user))
                                    $costArray = $product->calculatePayablePrice($user);
                                else
                                    $costArray = $product->calculatePayablePrice();

                                $cost += $costArray["cost"];
                                $costForCustomer += $costArray["customerPrice"];
                            }
                            //TODO:// age mahsool tamumshod ya yaft nashod chi?
                            //            elseif (!isset($simpleProduct))
                            //            {
                            //                $result = ['productWarning' => "محصول مورد نظر یافت نشد"];
                            //            } else
                            //            {
                            //                $result = ['productWarning' => "محصول مورد نظر تمام شده است"];
                            //            }
                        }
                        $result = [
                            "cost"            => $cost,
                            "costForCustomer" => $costForCustomer,
                        ];

                        $totalExtraCost = 0;
                        if (is_array($extraAttributeValues))
                            $totalExtraCost = $this->productExtraCostFromAttributes($product, $extraAttributeValues);

                        $result = array_add($result, 'totalExtraCost', $totalExtraCost);

                        return json_encode($result, JSON_UNESCAPED_UNICODE);
                    });

    }

    /**
     * Gets intended customer user account
     *
     * @return User
     */
    private function getCustomer(Request $request): ?User
    {
        if (session()->has("adminOrder_id"))
            return User::find(session()->get("customer_id"));
        return $request->user();

    }

    /**
     * Search for a product
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        return redirect(action("ProductController@index"), 301);
    }

    /**
     * enable or disable children of product
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \app\Product             $product
     *
     * @return \Illuminate\Http\Response
     */
    public function childProductEnable(Request $request, $product)
    {
        $parent = $product->parents->first();
        if ($product->enable == 1) {
            $product->enable = 0;
            foreach ($product->attributevalues as $attributevalue) {
                $flag = 0;
                $children = $parent->children->where("id", "!=", $product->id)
                                             ->where("enable", 1);
                foreach ($children as $child) {
                    if ($child->attributevalues->contains($attributevalue) == true) {
                        $flag = 1;
                        break;
                    }
                }
                if ($flag == 0)
                    $parent->attributevalues()
                           ->detach($attributevalue);
            }
        } else if ($product->enable == 0) {
            $product->enable = 1;
            foreach ($product->attributevalues as $attributevalue) {
                if ($parent->attributevalues->contains($attributevalue) == false) {
                    if (isset($attributevalue->pivot->extraCost) && $attributevalue->pivot->extraCost > 0)
                        $attributevalueDescription = "+" . number_format($attributevalue->pivot->extraCost) . "تومان"; else $attributevalueDescription = null;
                    $parent->attributevalues()
                           ->attach($attributevalue->id, ["description" => $attributevalueDescription]);
                }
            }
        }
        if ($product->update()) {
            session()->put('success', 'وضعیت فرزند محصول با موفقیت تغییر کرد');
        } else {
            session()->put('error', 'خطای پایگاه داده');
        }
        return redirect()->back();
    }

    /**
     * Show the form for configure the specified resource.
     *
     * @param  \app\Product $product
     *
     * @return \Illuminate\Http\Response
     */
    public function createConfiguration(Product $product)
    {
        $attributeCollection = collect();
        $attributeGroups = $product->attributeset->attributeGroups;
        foreach ($attributeGroups as $attributeGroup) {
            $attributeType = Attributetype::where("name", "main")
                                          ->get()
                                          ->first();
            $attributes = $product->attributeset->attributes()
                                                ->where("attributetype_id", $attributeType->id);
            foreach ($attributes as $attribute) {
                $attributeValues = $attribute->attributevalues;
                $attributeValuesCollect = collect();
                foreach ($attributeValues as $attributeValue) {
                    $attributeValuesCollect->push($attributeValue);
                    //                        array_push($attributeValuesArray , $attributeValue);
                }
                $attributeCollection->push([
                                               "attribute"        => $attribute,
                                               "attributeControl" => $attribute->attributecontrol->name,
                                               "attributevalues"  => $attributeValuesCollect,
                                           ]);
            }
        }
        return view("product.configureProduct.createConfiguration", compact("product", "attributeCollection"));
    }

    /**
     * make children for product
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \app\Product             $product
     *
     * @return \Illuminate\Http\Response
     */
    public function makeConfiguration(Request $request, $product)
    {

        $matrix = [];
        $array = []; // checkbox attribute values

        $attributeIds = $request->get("attributevalues");
        $extraCosts = $request->get("extraCost");
        $orders = $request->get("order");
        $descriptions = $request->get("description");
        $i = 0;
        foreach ($attributeIds as $attributeId) {
            $j = 0;
            foreach ($attributeId as $attributevalueId) {
                $extraCost = $extraCosts[$attributevalueId];
                if (!isset($extraCost[0]))
                    $extraCost = 0;

                $order = $orders[$attributevalueId];
                if (!isset($order[0]))
                    $order = 0;

                $description = $descriptions[$attributevalueId];
                if (!isset($description[0]))
                    $description = null;

                $attributevalue = Attributevalue::findOrFail($attributevalueId);
                $product->attributevalues()
                        ->attach($attributevalue, [
                            "extraCost"   => $extraCost,
                            "order"       => $order,
                            "description" => $description,
                        ]);
                if (strcmp($attributevalue->attribute->attributecontrol->name, "groupedCheckbox") == 0) {
                    array_push($array, $attributevalue->id);
                } else {
                    $matrix[$i][$j] = $attributevalue->id;
                    $j++;
                }
            }
            $i++;
        }

        if (sizeof($matrix) == 0)
            return redirect()->back();
        if (sizeof($matrix) == 1)
            $productConfigurations = current($matrix); else if (sizeof($matrix) >= 2) {
            $vertex = array_pop($matrix);
            $productConfigurations = $this->cartesianProduct($matrix, $vertex)[0];
        }

        foreach ($array as $item) {
            foreach ($productConfigurations as $productConfig) {
                $newProductConfig = $productConfig . "," . $item;
                array_push($productConfigurations, $newProductConfig);
            }
        }

        foreach ($productConfigurations as $productConfig) {
            $childProduct = $product->replicate();
            $childProduct->order = 0;
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
                $childProduct->parents()
                             ->attach($product);
                foreach ($attributevalues as $attributevalue) {

                    $extraCost = $extraCosts[$attributevalue->id];
                    if (!isset($extraCost[0]))
                        $extraCost = 0;

                    $order = $orders[$attributevalue->id];
                    if (!isset($order[0]))
                        $order = 0;

                    $description = $descriptions[$attributevalue->id];
                    if (!isset($description[0]))
                        $description = null;

                    $childProduct->attributevalues()
                                 ->attach($attributevalue, [
                                     "extraCost"   => $extraCost,
                                     "order"       => $order,
                                     "description" => $description,
                                 ]);
                }

            } else {
                session()->put('error', 'خطای پایگاه داده');
            }
        }
        return redirect(action("ProductController@edit", $product));
    }


    /**
     * Show the form for setting pivots for attributevalues
     *
     * @param  \app\Product $product
     *
     * @return \Illuminate\Http\Response
     */
    public function editAttributevalues(Product $product)
    {

        $attributeValuesCollection = collect();

        $attributeset = $product->attributeset;
        $attributeGroups = $attributeset->attributegroups;
        foreach ($attributeGroups as $attributeGroup) {
            $attributes = $attributeGroup->attributes->sortBy("order");
            foreach ($attributes as $attribute) {
                $type = Attributetype::FindOrFail($attribute->attributetype_id);
                $productAttributevlues = $product->attributevalues->where("attribute_id", $attribute->id);
                $attrributevalues = $attribute->attributevalues;
                if (!isset($attributeValuesCollection[$type->id]))
                    $attributeValuesCollection->put($type->id, collect([
                                                                           "name"        => $type->name,
                                                                           "displayName" => $type->description,
                                                                           "attributes"  => [],
                                                                       ]));
                $helperCollection = collect($attributeValuesCollection[$type->id]["attributes"]);
                $helperCollection->push([
                                            "name"                   => $attribute->displayName,
                                            "type"                   => $type,
                                            "values"                 => $attrributevalues,
                                            "productAttributevalues" => $productAttributevlues,
                                        ]);
                $attributeValuesCollection[$type->id]->put("attributes", $helperCollection);
            }
        }
        return view('product.configureProduct.editAttributevalues', compact('product', 'attributeValuesCollection'));
    }

    /**
     * set pivot for attributevalues
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \app\Product             $product
     *
     * @return \Illuminate\Http\Response
     */
    public function updateAttributevalues(Request $request, Product $product)
    {
        dd($request->all());
        $product->attributevalues()
                ->detach($product->attributevalues->pluck("id")
                                                  ->toArray());
        $newAttributevalues = $request->get("attributevalues");
        $newExtraCost = $request->get("extraCost");
        $newDescription = $request->get("description");
        foreach ($newAttributevalues as $attributevalueId) {
            $extraCost = $newExtraCost[$attributevalueId];
            if (strlen($extraCost) == 0)
                $extraCost = null;
            $description = $newDescription[$attributevalueId];
            if (strlen($extraCost) == 0)
                $extraCost = null;
            if ($product->attributevalues()
                        ->attach($attributevalueId, [
                            "extraCost"   => $extraCost,
                            "description" => $description,
                        ])) {
                $children = $product->children()
                                    ->whereHas("attributevalues", function ($q) use ($attributevalueId) {
                                        $q->where("id", $attributevalueId);
                                    })
                                    ->get();
                foreach ($children as $child) {
                    $child->attributevalues()
                          ->where("id", $attributevalueId)
                          ->updateExistingPivot($attributevalueId, [
                              "extraCost"   => $extraCost,
                              "description" => $description,
                          ]);
                }
            }
        }
        return redirect(action("ProductController@edit", $product));
    }

    /**
     * Attach a complimentary product to a product
     *
     * @param \App\Product                                      $product
     * @param \App\Http\Requests\AddComplimentaryProductRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function addComplimentary(AddComplimentaryProductRequest $request, Product $product)
    {
        $complimentary = Product::findOrFail($request->get("complimentaryproducts"));

        if ($product->complimentaryproducts->contains($complimentary)) {
            session()->put('error', 'این اشانتیون قبلا درج شده است');
        } else {
            $product->complimentaryproducts()
                    ->attach($complimentary);
            session()->put('success', 'درج اشانتیون با موفقیت انجام شد');
        }
        return redirect()->back();
    }

    /**
     * Detach a complimentary product to a product
     *
     * @param \App\Product             $complimentary
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function removeComplimentary(Request $request, Product $complimentary)
    {
        $product = Product::findOrFail($request->get("productId"));
        $product->complimentaryproducts()
                ->detach($complimentary);
        session()->put('success', 'حذف اشانتیون با موفقیت انجام شد');
        return $this->response->setStatusCode(200);
    }

    /**
     * Attach a gift product to a product
     *
     * @param \App\Product             $product
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function addGift(Request $request, Product $product)
    {
        $gift = Product::findOrFail($request->get("giftProducts"));

        if ($product->gifts->contains($gift)) {
            session()->put('error', 'این هدیه قبلا به این محصول اضافه شده است');
        } else {
            $product->gifts()
                    ->attach($gift, ["relationtype_id" => config("constants.PRODUCT_INTERRELATION_GIFT")]);
            session()->put('success', 'هدیه با موفقیت به محصول اضافه شد');
        }
        return redirect()->back();
    }

    /**
     * Detach a gift product to a product
     *
     * @param \App\Product             $product
     * @param \App\Product             $gift
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function removeGift(Request $request, Product $product)
    {
        $gift = Product::where("id", $request->get("giftId"))
                       ->get()
                       ->first();
        if (!isset($gift))
            return $this->response->setStatusCode(503)
                                  ->setContent(["message" => "خطا! چنین محصول هدیه ای وجود ندارد"]);

        if ($product->gifts()
                    ->detach($gift->id))
            return $this->response->setStatusCode(200)
                                  ->setContent(["message" => "هدیه با موفقیت حذف شد"]); else
            return $this->response->setStatusCode(503)
                                  ->setContent(["message" => "خطا در حذف هدیه . لطفا دوباره اقدام نمایید"]);
    }

    /**
     * Products Special Landing Page
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function landing1(Request $request)
    {
        $url = $request->url();

        $this->generateSeoMetaTags(new SeoDummyTags("آلاء| جمع بندی نیم سال اول", 'همایش ویژه دی ماه آلاء حمع بندی کنکور اساتید آلاء تست درسنامه تخفیف', $url, $url, route('image', [
            'category' => '11',
            'w'        => '100',
            'h'        => '100',
            'filename' => $this->setting->site->siteLogo,
        ]), '100', '100', null));

        $productIds = config("constants.HAMAYESH_PRODUCT");
        $products = Product::whereIn("id", $productIds)
                           ->orderBy("order")
                           ->where("enable", 1)
                           ->get();
        $attribute = Attribute::where("name", "major")
                              ->get()
                              ->first();
        $withFilter = true;

        $landingProducts = collect();
        foreach ($products as $product) {
            $majors = [];
            if (isset($attribute)) {
                $majors = $product->attributevalues->where("attribute_id", $attribute->id)
                                                   ->pluck("name")
                                                   ->toArray();
            }

            $landingProducts->push([
                                       "product" => $product,
                                       "majors"  => $majors,
                                   ]);
        }

        $costCollection = $this->makeCostCollection($products);
        return view("product.landing.landing1", compact("landingProducts", "costCollection", "withFilter"));
    }

    /**
     * Products Special Landing Page
     *
     * @return \Illuminate\Http\Response
     */
    public function landing2()
    {
        return redirect("/landing/4", 302);
        $gheireHozoori = config("constants.ORDOO_GHEIRE_HOZOORI_NOROOZ_97_PRODUCT_ALLTOGHETHER");
        if (Input::has("utm_term")) {
            $utm_term = Input::get("utm_term");
            switch ($utm_term) {
                case "700":
                    $gheireHozoori = config("constants.ORDOO_GHEIRE_HOZOORI_NOROOZ_97_PRODUCT_ALLTOGHETHER");
                    break;
                case "260":
                    $gheireHozoori = config("constants.ORDOO_GHEIRE_HOZOORI_NOROOZ_97_PRODUCT_DEFAULT");
                    break;
                default:
                    break;
            }
        }

        $products = Product::whereIn("id", config("constants.ORDOO_GHEIRE_HOZOORI_NOROOZ_97_PRODUCT"))
                           ->orwhereIn("id", config("constants.ORDOO_HOZOORI_NOROOZ_97_PRODUCT"))
                           ->orderBy("order")
                           ->where("enable", 1)
                           ->get();

        $landingProducts = collect();
        foreach ($products as $product) {
            $landingProducts->push(["product" => $product]);
        }
        $costCollection = $this->makeCostCollection($products);
        return view("product.landing.landing2", compact("landingProducts", "costCollection", "utm_term", "gheireHozoori"));
    }

    /**
     * Products Special Landing Page
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function landing3(Request $request)
    {
        $url = $request->url();
        $this->generateSeoMetaTags(new SeoDummyTags("آلاء | همایش های طلایی کنکور 97", 'وقتی همه کنکوری ها گیج و سرگردانند، شما مرور کنید. چالشی ترین نکات کنکوری در همایش های آلاء', $url, $url, route('image', [
            'category' => '11',
            'w'        => '100',
            'h'        => '100',
            'filename' => $this->setting->site->siteLogo,
        ]), '100', '100', null));

        return view("product.landing.landing3");
    }

    /**
     * Products Special Landing Page
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function landing4(Request $request)
    {
        return redirect()->route('landing.3', $request->all());

        $url = $request->url();
        $this->generateSeoMetaTags(new SeoDummyTags("آلاء | همایش های طلایی کنکور 97", 'وقتی همه کنکوری ها گیج و سرگردانند، شما مرور کنید. چالشی ترین نکات کنکوری در همایش های آلاء', $url, $url, route('image', [
            'category' => '11',
            'w'        => '100',
            'h'        => '100',
            'filename' => $this->setting->site->siteLogo,
        ]), '100', '100', null));
        return view("product.landing.landing4");
    }

    /**
     * Copy a product completely
     *
     * @param \App\Product $product
     *
     * @return \Illuminate\Http\Response
     */
    public function copy(Product $product)
    {
        $newProduct = $product->replicate();
        $correspondenceArray = [];
        $done = true;
        if ($newProduct->save()) {
            /**
             * Copying children
             */
            if ($product->hasChildren()) {
                foreach ($product->children as $child) {
                    $response = $this->copy($child);
                    if ($response->getStatusCode() == 200) {
                        $response = json_decode($response->getContent());
                        $newChildId = $response->newProductId;
                        if (isset($newChildId)) {
                            $correspondenceArray[$child->id] = $newChildId;
                            $newProduct->children()
                                       ->attach($newChildId);
                        } else {
                            $done = false;
                        }
                    } else {
                        $done = false;
                    }
                }
            }

            /**
             * Copying attributeValues
             */
            foreach ($product->attributevalues as $attributevalue) {
                $newProduct->attributevalues()
                           ->attach($attributevalue->id, [
                               "extraCost"   => $attributevalue->pivot->extraCost,
                               "description" => $attributevalue->pivot->description,
                           ]);
            }

            /**
             * Copying bons
             */
            foreach ($product->bons as $bon) {
                $newProduct->bons()
                           ->attach($bon->id, [
                               "discount" => $bon->pivot->discount,
                               "bonPlus"  => $bon->pivot->bonPlus,
                           ]);
            }

            /**
             * Copying coupons
             */
            $newProduct->coupons()
                       ->attach($product->coupons->pluck('id')
                                                 ->toArray());

            /**
             * Copying complimentary
             */
            foreach ($product->complimentaryproducts as $complimentaryproduct) {
                $flag = $this->haveSameFamily(collect([
                                                          $product,
                                                          $complimentaryproduct,
                                                      ]));
                if (!$flag) {
                    $newProduct->complimentaryproducts()
                               ->attach($complimentaryproduct->id);
                }

            }

            /**
             * Copying gifts
             */
            foreach ($product->gifts as $gift) {
                $flag = $this->haveSameFamily(collect([
                                                          $product,
                                                          $gift,
                                                      ]));
                if (!$flag) {
                    $newProduct->gifts()
                               ->attach($gift->id, ["relationtype_id" => config("constants.PRODUCT_INTERRELATION_GIFT")]);
                }
            }

            if ($product->hasChildren()) {
                $children = $product->children;
                foreach ($children as $child) {
                    $childComplementarities = $child->complimentaryproducts;
                    $intersects = $childComplementarities->intersect($children);
                    foreach ($intersects as $intersect) {
                        $correspondingChild = Product::where("id", $correspondenceArray[$child->id])
                                                     ->get()
                                                     ->first();
                        $correspondingComplimentary = $correspondenceArray[$intersect->id];
                        $correspondingChild->complimentaryproducts()
                                           ->attach($correspondingComplimentary);
                    }
                }
            }

            if ($done == false) {
                foreach ($newProduct->children as $child) {
                    $child->forceDelete();
                }
                $newProduct->forceDelete();
                return $this->response->setStatusCode(503)
                                      ->setContent(["message" => "خطا در کپی از الجاقی محصول . لطفا دوباره اقدام نمایید"]);
            } else {
                return $this->response->setStatusCode(200)
                                      ->setContent([
                                                       "message"      => "عملیات کپی با موفقیت انجام شد.",
                                                       "newProductId" => $newProduct->id,
                                                   ]);
            }
        } else {
            return $this->response->setStatusCode(503)
                                  ->setContent(["message" => "خطا در کپی از اطلاعات پایه ای محصول . لطفا دوباره اقدام نمایید"]);
        }
    }

}
