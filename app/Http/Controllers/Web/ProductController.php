<?php

namespace App\Http\Controllers\Web;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\{Request, Response};
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\{Arr, Collection, Facades\File, Facades\Storage};
use App\{Adapter\AlaaSftpAdapter,
    Bon,
    Product,
    Attributeset,
    Attributetype,
    Traits\FileCommon,
    Traits\Helper,
    Attributevalue,
    User,
    Websitesetting,
    Productfiletype,
    Traits\MathCommon,
    Traits\MetaCommon,
    Traits\SearchCommon,
    Traits\ProductCommon,
    Traits\RequestCommon,
    Traits\CharacterCommon,
    Classes\SEO\SeoDummyTags,
    Classes\Search\ProductSearch,
    Http\Requests\EditProductRequest,
    Http\Requests\ProductIndexRequest,
    Http\Requests\InsertProductRequest,
    Http\Requests\AddComplimentaryProductRequest};

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
    use SearchCommon;
    use FileCommon;

    private $setting;


    public function __construct(Websitesetting $setting)
    {
        $this->setting  = $setting->setting;
        $this->callMiddlewares();
    }

    private function callMiddlewares(): void
    {
        //        $this->middleware('permission:' . config('constants.LIST_PRODUCT_ACCESS'), ['only' => 'index']);
        $this->middleware('permission:'.config('constants.INSERT_PRODUCT_ACCESS'), ['only' => 'create']);
        $this->middleware('permission:'.config('constants.REMOVE_PRODUCT_ACCESS'), ['only' => 'destroy']);
        $this->middleware('permission:'.config('constants.SHOW_PRODUCT_ACCESS'), ['only' => 'edit']);
        $this->middleware('permission:'.config('constants.EDIT_PRODUCT_ACCESS'), ['only' => 'update']);
        $this->middleware('permission:'.config('constants.EDIT_CONFIGURE_PRODUCT_ACCESS'), [
            'only' => [
                'childProductEnable',
                'completeEachChildPivot',
            ],
        ]);
        $this->middleware('permission:'.config('constants.INSERT_CONFIGURE_PRODUCT_ACCESS'), [
            'only' => 'makeConfiguration',
            'createConfiguration',
        ]);
        $this->middleware('auth', [
            'except' => [
                'index',
                'show',
                'search',
            ],
        ]);
    }

    public function index(ProductIndexRequest $request, ProductSearch $productSearch)
    {
        $tags          = $request->get('tags');
        $filters       = $request->all();
        $pageName      = 'productPage';
        if(!$request->has('moderator')) {
            $filters['active'] = 1 ;
        }

        $productSearch->setPageName($pageName);
        if($request->has('length')){
            $productSearch->setNumberOfItemInEachPage($request->get('length'));
        }

        $productResult = $productSearch->get($filters);

        $products = $productResult;
        if (request()->expectsJson()) {
            return response()->json([
                'result' => $products,
                'tags'   => $tags,
            ]);
        }

        $url = $request->url();
        $this->generateSeoMetaTags(new SeoDummyTags('محصولات '.$this->setting->site->name,
            'کارگاه تست کنکور، همایش، جمع بندی و اردوطلایی نوروز آلاء', $url,
            $url, route('image', [
                'category' => '11',
                'w'        => '100',
                'h'        => '100',
                'filename' => $this->setting->site->siteLogo,
            ]), '100', '100', null));


        return view('pages.product-search', compact('products', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  InsertProductRequest  $request
     *
     * @return Response
     * @throws FileNotFoundException
     */
    public function store(InsertProductRequest $request)
    {
        $product = new Product();

        $bonPlus = $request->get('bonPlus');
        if ($this->strIsEmpty($bonPlus)) {
            $bonPlus = 0;
        }

        $bonDiscount = $request->get('bonDiscount');
        if ($this->strIsEmpty($bonDiscount)) {
            $bonDiscount = 0;
        }

        $bonId = $request->get('bon_id');

        $this->fillProductFromRequest($request->all(), $product);

        if ($product->save()) {
            if ($bonPlus || $bonDiscount) {
                $this->attachBonToProduct($product, $bonId, $bonDiscount, $bonPlus);
            }

            return response()->json();
        }

        return response()->json([] , Response::HTTP_SERVICE_UNAVAILABLE);
    }

    public function show(Request $request, Product $product)
    {
        //$user = $request->user();
        $user = null;
         if ($user) {
             $purchasedProductIdArray = $this->searchInUserAssetsCollection($product, $user);
             $allChildIsPurchased = $this->allChildIsPurchased($product, $purchasedProductIdArray);
         } else {
             $purchasedProductIdArray = [];
             $allChildIsPurchased = false;
         }

        if (isset($product->redirectUrl)) {
            return redirect($product->redirectUrl, Response::HTTP_FOUND, $request->headers->all());
        }

        if ($product->grandParent != null) {
            return redirect($product->grandParent->url, Response::HTTP_MOVED_PERMANENTLY, $request->headers->all());
        }

        $this->generateSeoMetaTags($product);

        if (request()->expectsJson()) {
            return response()->json($product);
        }

        $block = optional($product)->block;

        return view('product.show', compact('product', 'block', 'purchasedProductIdArray', 'allChildIsPurchased'));
    }

    public function edit(Product $product)
    {
        $bonName                  = config('constants.BON1');
        $amountLimit              = Product::AMOUNT_LIMIT;
        $defaultProductPhotoOrder = 0;
        $defaultAmountLimit       = 0;
        $defaultEnableStatus      = 0;
        $enableStatus             = Product::ENABLE_STATUS;

        if ($product->isLimited()) {
            $defaultAmountLimit = 1;
        }

        if ($product->enable) {
            $defaultEnableStatus = 1;
        }

        $attributesets = Attributeset::pluck('name', 'id')
            ->toArray();

        $bons = $product->bons();
        $bons->enable();
        $bons->ofName($bonName);
        $bons = $bons->get()
            ->first();

        if (!isset($bons)) {
            $bons = Bon::ofName($bonName)
                ->first();
        }

        $productFiles             = $product->productfiles->sortBy('order');
        $defaultProductFileOrders = $product->productFileTypesOrder();

        $productFileTypes = Productfiletype::makeSelectArray();

        $products    = $this->makeProductCollection();
        $producttype = $product->producttype->displayName;

        $productPhotos = $product->photos->sortByDesc('order');
        if ($productPhotos->isNotEmpty()) {
            $defaultProductPhotoOrder = $productPhotos->first()->order + 1;
        }

        $tags = optional($product->tags)->tags;
        $tags = implode(',', isset($tags) ? $tags : []);

        return view('product.edit',
            compact('product', 'amountLimit', 'defaultAmountLimit', 'enableStatus', 'defaultEnableStatus',
                'attributesets', 'bons', 'productFiles',
                'productFileTypes', 'defaultProductFileOrders', 'products', 'producttype', 'productPhotos',
                'defaultProductPhotoOrder', 'tags'));
    }

    public function update(EditProductRequest $request, Product $product)
    {
        $bonId = $request->get('bon_id');
        if ($this->strIsEmpty($request->get('bonPlus'))) {
            $bonPlus = 0;
        } else {
            $bonPlus = $request->get('bonPlus');
        }

        if ($this->strIsEmpty($request->get('bonDiscount'))) {
            $bonDiscount = 0;
        } else {
            $bonDiscount = $request->get('bonDiscount');
        }
        $childrenPriceEqualizer = $request->has('changeChildrenPrice');

        $this->fillProductFromRequest($request->all(), $product);

        if ($childrenPriceEqualizer) {
            $product->equalizingChildrenPrice();
        }

        if ($bonPlus || $bonDiscount) {
            $this->attachBonToProduct($product, $bonId, $bonDiscount, $bonPlus);
        }

        if ($product->update()) {
            session()->put('success', 'اصلاح محصول با موفقیت انجام شد');
        } else {
            session()->put('error', 'خطای پایگاه داده');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @param  Product  $product
     *
     * @return Response
     * @throws Exception
     */
    public function destroy(Request $request, Product $product)
    {
        $done = false;
        if ($product->delete()) {
            $done = true;
        }

        if ($request->expectsJson()) {
            if ($done) {
                return response()->json();
            }

            return response()->json([] , Response::HTTP_SERVICE_UNAVAILABLE);
        }

        if ($done) {
            session()->put('success', 'محصول با موفقیت اصلاح شد');
        } else {
            session()->put('error', 'خطای پایگاه داده');
        }

        return redirect()->back();
    }

    /**
     * Search for a product
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function search(Request $request)
    {
        return redirect(action("Web\ProductController@index"), 301);
    }

    /**
     * enable or disable children of product
     *
     * @param  Request  $request
     * @param  Product  $product
     *
     * @return Response
     */
    public function childProductEnable(Request $request, $product)
    {
        $parent = $product->parents->first();
        if ($product->enable == 1) {
            $product->enable = 0;
            foreach ($product->attributevalues as $attributevalue) {
                $flag     = 0;
                $children = $parent->children->where('id', '!=', $product->id)
                    ->where('enable', 1);
                foreach ($children as $child) {
                    if ($child->attributevalues->contains($attributevalue) == true) {
                        $flag = 1;
                        break;
                    }
                }
                if ($flag == 0) {
                    $parent->attributevalues()
                        ->detach($attributevalue);
                }
            }
        } else {
            if ($product->enable == 0) {
                $product->enable = 1;
                foreach ($product->attributevalues as $attributevalue) {
                    if ($parent->attributevalues->contains($attributevalue) == false) {
                        if (isset($attributevalue->pivot->extraCost) && $attributevalue->pivot->extraCost > 0) {
                            $attributevalueDescription = '+'.number_format($attributevalue->pivot->extraCost).'تومان';
                        } else {
                            $attributevalueDescription = null;
                        }
                        $parent->attributevalues()
                            ->attach($attributevalue->id, ['description' => $attributevalueDescription]);
                    }
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
     * @param  Product  $product
     *
     * @return Response
     */
    public function createConfiguration(Product $product)
    {
        $attributeCollection = collect();
        $attributeGroups     = $product->attributeset->attributeGroups;
        foreach ($attributeGroups as $attributeGroup) {
            $attributeType = Attributetype::where('name', 'main')
                ->get()
                ->first();
            $attributes    = $product->attributeset->attributes()
                ->where('attributetype_id', $attributeType->id);
            foreach ($attributes as $attribute) {
                $attributeValues        = $attribute->attributevalues;
                $attributeValuesCollect = collect();
                foreach ($attributeValues as $attributeValue) {
                    $attributeValuesCollect->push($attributeValue);
                    //                        array_push($attributeValuesArray , $attributeValue);
                }
                $attributeCollection->push([
                    'attribute'        => $attribute,
                    'attributeControl' => $attribute->attributecontrol->name,
                    'attributevalues'  => $attributeValuesCollect,
                ]);
            }
        }

        return view('product.configureProduct.createConfiguration', compact('product', 'attributeCollection'));
    }

    /**
     * make children for product
     *
     * @param  Request  $request
     * @param  Product  $product
     *
     * @return Response
     */
    public function makeConfiguration(Request $request, $product)
    {

        $matrix = [];
        $array  = []; // checkbox attribute values

        $attributeIds = $request->get('attributevalues');
        $extraCosts   = $request->get('extraCost');
        $orders       = $request->get('order');
        $descriptions = $request->get('description');
        $i            = 0;
        foreach ($attributeIds as $attributeId) {
            $j = 0;
            foreach ($attributeId as $attributevalueId) {
                $extraCost = $extraCosts[$attributevalueId];
                if (!isset($extraCost[0])) {
                    $extraCost = 0;
                }

                $order = $orders[$attributevalueId];
                if (!isset($order[0])) {
                    $order = 0;
                }

                $description = $descriptions[$attributevalueId];
                if (!isset($description[0])) {
                    $description = null;
                }

                $attributevalue = Attributevalue::findOrFail($attributevalueId);
                $product->attributevalues()
                    ->attach($attributevalue, [
                        'extraCost'   => $extraCost,
                        'order'       => $order,
                        'description' => $description,
                    ]);
                if (strcmp($attributevalue->attribute->attributecontrol->name, 'groupedCheckbox') == 0) {
                    $array[] = $attributevalue->id;
                } else {
                    $matrix[$i][$j] = $attributevalue->id;
                    $j++;
                }
            }
            $i++;
        }

        if (count($matrix) == 0) {
            return redirect()->back();
        }
        if (count($matrix) == 1) {
            $productConfigurations = current($matrix);
        } else {
            if (count($matrix) >= 2) {
                $vertex                = array_pop($matrix);
                $productConfigurations = $this->cartesianProduct($matrix, $vertex)[0];
            }
        }

        foreach ($array as $item) {
            foreach ($productConfigurations as $productConfig) {
                $newProductConfig        = $productConfig.','.$item;
                $productConfigurations[] = $newProductConfig;
            }
        }

        foreach ($productConfigurations as $productConfig) {
            $childProduct        = $product->replicate();
            $childProduct->order = 0;
            $attributevalueIds   = explode(',', $productConfig);
            $productName         = '';
            $attributevalues     = [];
            foreach ($attributevalueIds as $attributevalueId) {
                $attributevalue    = Attributevalue::findOrFail($attributevalueId);
                $attributevalues[] = $attributevalue;
                $productName       = $productName.'-'.$attributevalue->name;
            }
            $childProduct->name           = $product->name.$productName;
            $childProduct->producttype_id = 1;
            if ($childProduct->save()) {
                $childProduct->parents()
                    ->attach($product);
                foreach ($attributevalues as $attributevalue) {

                    $extraCost = $extraCosts[$attributevalue->id];
                    if (!isset($extraCost[0])) {
                        $extraCost = 0;
                    }

                    $order = $orders[$attributevalue->id];
                    if (!isset($order[0])) {
                        $order = 0;
                    }

                    $description = $descriptions[$attributevalue->id];
                    if (!isset($description[0])) {
                        $description = null;
                    }

                    $childProduct->attributevalues()
                        ->attach($attributevalue, [
                            'extraCost'   => $extraCost,
                            'order'       => $order,
                            'description' => $description,
                        ]);
                }
            } else {
                session()->put('error', 'خطای پایگاه داده');
            }
        }

        return redirect(action("Web\ProductController@edit", $product));
    }

    /**
     * Show the form for setting pivots for attributevalues
     *
     * @param  Product  $product
     *
     * @return Response
     */
    public function editAttributevalues(Product $product)
    {

        $attributeValuesCollection = collect();

        $attributeset    = $product->attributeset;
        $attributeGroups = $attributeset->attributegroups;
        foreach ($attributeGroups as $attributeGroup) {
            $attributes = $attributeGroup->attributes->sortBy('order');
            foreach ($attributes as $attribute) {
                $type                  = Attributetype::FindOrFail($attribute->attributetype_id);
                $productAttributevlues = $product->attributevalues->where('attribute_id', $attribute->id);
                $attrributevalues      = $attribute->attributevalues;
                if (!isset($attributeValuesCollection[$type->id])) {
                    $attributeValuesCollection->put($type->id, collect([
                        'name'        => $type->name,
                        'displayName' => $type->description,
                        'attributes'  => [],
                    ]));
                }
                $helperCollection = collect($attributeValuesCollection[$type->id]['attributes']);
                $helperCollection->push([
                    'name'                   => $attribute->displayName,
                    'type'                   => $type,
                    'values'                 => $attrributevalues,
                    'productAttributevalues' => $productAttributevlues,
                ]);
                $attributeValuesCollection[$type->id]->put('attributes', $helperCollection);
            }
        }

        return view('product.configureProduct.editAttributevalues', compact('product', 'attributeValuesCollection'));
    }

    /**
     * set pivot for attributevalues
     *
     * @param  Request  $request
     * @param  Product  $product
     *
     * @return Response
     */
    public function updateAttributevalues(Request $request, Product $product)
    {
        dd($request->all());
        $product->attributevalues()
            ->detach($product->attributevalues->pluck('id')
                ->toArray());
        $newAttributevalues = $request->get('attributevalues');
        $newExtraCost       = $request->get('extraCost');
        $newDescription     = $request->get('description');
        foreach ($newAttributevalues as $attributevalueId) {
            $extraCost = $newExtraCost[$attributevalueId];
            if (strlen($extraCost) == 0) {
                $extraCost = null;
            }
            $description = $newDescription[$attributevalueId];
            if (strlen($extraCost) == 0) {
                $extraCost = null;
            }
            if ($product->attributevalues()
                ->attach($attributevalueId, [
                    'extraCost'   => $extraCost,
                    'description' => $description,
                ])) {
                $children = $product->children()
                    ->whereHas('attributevalues', function ($q) use ($attributevalueId) {
                        $q->where('id', $attributevalueId);
                    })
                    ->get();
                foreach ($children as $child) {
                    $child->attributevalues()
                        ->where('id', $attributevalueId)
                        ->updateExistingPivot($attributevalueId, [
                            'extraCost'   => $extraCost,
                            'description' => $description,
                        ]);
                }
            }
        }

        return redirect(action("Web\ProductController@edit", $product));
    }

    /**
     * Attach a complimentary product to a product
     *
     * @param  Product                         $product
     * @param  AddComplimentaryProductRequest  $request
     *
     * @return Response
     */
    public function addComplimentary(AddComplimentaryProductRequest $request, Product $product)
    {
        $complimentary = Product::findOrFail($request->get('complimentaryproducts'));

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
     * @param  Product  $complimentary
     * @param  Request  $request
     *
     * @return Response
     */
    public function removeComplimentary(Request $request, Product $complimentary)
    {
        $product = Product::findOrFail($request->get('productId'));
        $product->complimentaryproducts()
            ->detach($complimentary);
        session()->put('success', 'حذف اشانتیون با موفقیت انجام شد');

        return response()->json();
    }

    /**
     * Attach a gift product to a product
     *
     * @param  Product  $product
     * @param  Request  $request
     *
     * @return Response
     */
    public function addGift(Request $request, Product $product)
    {
        $gift = Product::findOrFail($request->get('giftProducts'));

        if ($product->gifts->contains($gift)) {
            session()->put('error', 'این هدیه قبلا به این محصول اضافه شده است');
        } else {
            $product->gifts()
                ->attach($gift, ['relationtype_id' => config('constants.PRODUCT_INTERRELATION_GIFT')]);
            session()->put('success', 'هدیه با موفقیت به محصول اضافه شد');
        }

        return redirect()->back();
    }

    /**
     * Detach a gift product to a product
     *
     * @param  Product  $product
     * @param  Product  $gift
     * @param  Request  $request
     *
     * @return Response
     */
    public function removeGift(Request $request, Product $product)
    {
        $gift = Product::where('id', $request->get('giftId'))
            ->get()
            ->first();
        if (!isset($gift)) {
            return response()->json(['message' => 'خطا! چنین محصول هدیه ای وجود ندارد'],
                Response::HTTP_SERVICE_UNAVAILABLE);
        }

        if ($product->gifts()
            ->detach($gift->id)) {
            return response()->json(['message' => 'هدیه با موفقیت حذف شد']);
        } else {
            return response()->json(['message' => 'خطا در حذف هدیه . لطفا دوباره اقدام نمایید'],
                Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }

    /**
     * Copy a product completely
     *
     * @param  Product  $product
     *
     * @return Response
     */
    public function copy(Product $product)
    {
        $newProduct          = $product->replicate();
        $correspondenceArray = [];
        $done                = true;
        if ($newProduct->save()) {
            /**
             * Copying children
             */
            if ($product->hasChildren()) {
                foreach ($product->children as $child) {
                    $response = $this->copy($child);
                    if ($response->getStatusCode() == Response::HTTP_OK) {
                        $response   = json_decode($response->getContent());
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
                        'extraCost'   => $attributevalue->pivot->extraCost,
                        'description' => $attributevalue->pivot->description,
                    ]);
            }

            /**
             * Copying bons
             */
            foreach ($product->bons as $bon) {
                $newProduct->bons()
                    ->attach($bon->id, [
                        'discount' => $bon->pivot->discount,
                        'bonPlus'  => $bon->pivot->bonPlus,
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
                        ->attach($gift->id, ['relationtype_id' => config('constants.PRODUCT_INTERRELATION_GIFT')]);
                }
            }

            if ($product->hasChildren()) {
                $children = $product->children;
                foreach ($children as $child) {
                    $childComplementarities = $child->complimentaryproducts;
                    $intersects             = $childComplementarities->intersect($children);
                    foreach ($intersects as $intersect) {
                        $correspondingChild         = Product::where('id', $correspondenceArray[$child->id])
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

                return response()->json(['message' => 'خطا در کپی از الجاقی محصول . لطفا دوباره اقدام نمایید'],
                    Response::HTTP_SERVICE_UNAVAILABLE);
            }

            return response()->json([
                'message'      => 'عملیات کپی با موفقیت انجام شد.',
                'newProductId' => $newProduct->id,
            ]);
        }

        return response()->json(['message' => 'خطا در کپی از اطلاعات پایه ای محصول . لطفا دوباره اقدام نمایید'],
            Response::HTTP_SERVICE_UNAVAILABLE);
    }



    /**
     * @param $introVideo
     * @param $introVideoThumbnail
     *
     * @return Collection
     */
    private function setIntroVideos($introVideo, $introVideoThumbnail)
    {
        $videos = null;
        if (isset($introVideo)) {
            $videos = $this->makeIntroVideos($introVideo);
        }

        $thumbnail = null;
        if (isset($introVideoThumbnail)) {
            $thumbnail = $this->makeIntroVideoThumbnail($introVideoThumbnail);
        }

        return $this->makeIntroVideoCollection($videos, $thumbnail);
    }

    /**
     * @param  array  $videos
     * @param  array  $thumbnail
     *
     * @return Collection
     */
    private function makeIntroVideoCollection(array $videos = null, array $thumbnail = null): Collection
    {
        $introVideos = collect();
        $introVideos->push([
            'video'     => $videos,
            'thumbnail' => $thumbnail,
        ]);

        return $introVideos;
    }

    /**
     * @param  string  $thumbnailLink
     *
     * @return array
     */
    private function makeIntroVideoThumbnail(string $thumbnailLink): array
    {
        $thumbnailUrl       = $thumbnailLink;
        $thumbnailPath      = parse_url($thumbnailUrl)['path'];
        $thumbnailExtension = pathinfo($thumbnailPath, PATHINFO_EXTENSION);
        $thumbnail          = $this->makeVideoFileThumbnailStdClass(config('constants.DISK_FREE_CONTENT'),
            $thumbnailUrl, $thumbnailPath, $thumbnailExtension);
        return $thumbnail;
    }

    /**
     * @param  string  $videoLink
     *
     * @return array
     */
    private function makeIntroVideos(string $videoLink): array
    {
        $videoUrl       = $videoLink;
        $videoPath      = parse_url($videoUrl)['path'];
        $videoExtension = pathinfo($videoPath, PATHINFO_EXTENSION);
        $hqVideo        = $this->makeIntroVideoFileStdClass(config('constants.DISK_FREE_CONTENT'), $videoUrl,
            $videoPath, $videoExtension, null, 'کیفیت بالا', '480p');
        $videos         = $this->mekeIntroVideosArray($hqVideo);
        return $videos;
    }

    /**
     * @param  array    $inputData
     * @param  Product  $product
     *
     * @return void
     * @throws FileNotFoundException
     */
    private function fillProductFromRequest(array $inputData, Product $product): void
    {
        $files     = Arr::has($inputData, 'files') ? [Arr::get($inputData, 'files')] : [];
        $images    = Arr::has($inputData, 'image') ? [Arr::get($inputData, 'image')] : [];
        $isFree    = Arr::has($inputData, 'isFree');
        $tagString = Arr::get($inputData, 'tags');

        $product->fill($inputData);

        if (strlen($tagString) > 0) {
            $product->tags = convertTagStringToArray($tagString);
        }

        if ($this->strIsEmpty($product->discount)) {
            $product->discount = 0;
        }

        $product->isFree = $isFree;

        $product->intro_videos = $this->setIntroVideos(Arr::get($inputData, 'introVideo'),
            Arr::get($inputData, 'introVideoThumbnail'));

        //Storing product's catalog
        $storeFileResult = $this->storeCatalogOfProduct($product, $files);
        //ToDo : delete the file if it is an update

        //Storing product's image
        $storeImageResult = $this->storeImageOfProduct($product, $images);
        //ToDo : delete the file if it is an update
    }

    /** Stores catalog file of the product
     *
     * @param  Product  $product
     *
     * @param  array    $files
     *
     * @return array
     * @throws FileNotFoundException
     */
    private function storeCatalogOfProduct(Product $product, array $files): array
    {
        $done = [];
        foreach ($files as $key => $file) {
            $extension  = $file->getClientOriginalExtension();
            $fileName   = basename($file->getClientOriginalName(), '.'.$extension).'_'.date('YmdHis').'.'.$extension;
            $done[$key] = false;
            if (Storage::disk(config('constants.DISK5'))
                ->put($fileName, File::get($file))) {
                $product->file = $fileName;
                $done[$key]    = true;
            }
        }

        return $done;
    }

    /** Stores image file of the product
     *
     * @param  Product  $product
     *
     * @param  array    $files
     *
     * @return array
     * @throws FileNotFoundException
     */
    private function storeImageOfProduct(Product $product, array $files): array
    {
        $done = [];
        foreach ($files as $key => $file) {
            $extension  = $file->getClientOriginalExtension();
            $fileName   = basename($file->getClientOriginalName(), '.'.$extension).'_'.date('YmdHis').'.'.$extension;
            $disk = Storage::disk(config('constants.DISK21'));
            /** @var AlaaSftpAdapter $adaptor */
            $adaptor = $disk->getAdapter();
            $done[$key] = false;
            if ($disk->put($fileName, File::get($file))) {
                $fullPath = $adaptor->getRoot();
                $partialPath = $this->getSubDirectoryInCDN($fullPath);

                $done[$key]     = true;
                $product->image = $partialPath.$fileName;
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

    /**
     * @param $product
     * @param $bonId
     * @param $bonDiscount
     * @param $bonPlus
     */
    private function attachBonToProduct(Product $product, $bonId, $bonDiscount, $bonPlus): void
    {
        $bonQueryBuilder = $product->bons();

        if ($product->hasBon($bonId)) {
            $bonQueryBuilder->updateExistingPivot($bonId, [
                'discount' => $bonDiscount,
                'bonPlus'  => $bonPlus,
            ]);
        } else {
            $bonQueryBuilder->attach($bonId, [
                'discount' => $bonDiscount,
                'bonPlus'  => $bonPlus,
            ]);
        }
    }

    private function searchInUserAssetsCollection(Product $product, User $user) {

        $purchasedProductIdArray = [];
        $userAssetsCollection = $user->getDashboardBlocks()->pluck('products');
        foreach ($userAssetsCollection as $blockProducts) {
            foreach ($blockProducts as $product1) {
                $this->iterateProductAndChildren($product1->id, $product, $purchasedProductIdArray);
            }
        }

        return $purchasedProductIdArray;
    }

    private function allChildIsPurchased(Product $product, $purchasedProductIdArray) {
        if ($product->children->count() > 0) {
            foreach ($product->children as $productChild) {
                if (array_search($product->id, $purchasedProductIdArray) === false) {
                    $res = $this->allChildIsPurchased($productChild, $purchasedProductIdArray);
                    if (!$res) {
                        return false;
                    }
                }
            }
        } elseif (array_search($product->id, $purchasedProductIdArray) === false) {
            return false;
        } else {
            return true;
        }
        return true;
    }

    private function iterateProductAndChildren($searchProductId, Product $product, array & $purchasedProductIdArray) {

        if ($searchProductId === $product->id) {
            $purchasedProductIdArray[] = $product->id;
        }

        if ($product->children->count() > 0) {
            foreach ($product->children as $key=>$childProduct) {
                $this->iterateProductAndChildren($searchProductId, $childProduct, $purchasedProductIdArray);
            }
        }
    }
}
