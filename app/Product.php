<?php

namespace App;

use App\Traits\ProductCommon;
use  App\Helpers\Helper;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use SoftDeletes;
//    use Searchable;
    use ProductCommon;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'name',
        'basePrice',
        'shortDescription',
        'longDescription',
        'slogan',
        'image',
        'file',
        'validSince',
        'validUntil',
        'enable',
        'order',
        'producttype_id',
        'discount',
        'amount',
        'attributeset_id',
        'introVideo',
        'isFree',
        'specialDescription'
    ];

    public function cacheKey()
    {
        $key = $this->getKey();
        $time= isset($this->update) ? $this->updated_at->timestamp : $this->created_at->timestamp;
        return sprintf(
            "%s-%s",
            //$this->getTable(),
            $key,
            $time
        );
    }



    public static function recentProducts($number)
    {
        return self::getProducts(0, 1)->take($number)->orderBy('created_at', 'Desc');
    }

    public static function getProducts($configurable = 0, $enable = 0)
    {
        if ($configurable == 1) {
            $products = \App\Product::configurable();
            if ($enable == 1)
                $products = $products->enable();
        } else if ($configurable == 0) {
            $products = \App\Product::select()->doesntHave('parents');
            if ($enable == 1)
                $products->enable();
        }

        return $products;
    }

    public function producttype()
    {
        return $this->belongsTo('App\Producttype')->withDefault();
    }

    public function attributeset()
    {
        return $this->belongsTo('App\Attributeset')->orderBy('order');
    }

    public function children()
    {
        return $this->belongsToMany('App\Product',
                                    'childproduct_parentproduct',
                                    'parent_id',
                                    'child_id')
                    ->withPivot("isDefault",
                                        "control_id",
                                        "description",
                                        "parent_id")
                    ->with('children');
    }

    public function parents()
    {
        return $this->belongsToMany('App\Product',
            'childproduct_parentproduct',
            'child_id',
            'parent_id')
            ->withPivot("isDefault", "control_id", "description");
    }

    public function orderproducts()
    {
        return $this->hasMany('App\Orderproduct');
    }

    public function getDisplayName()
    {
        $key="product:getDisplayName:".$this->cacheKey();

        return Cache::remember($key,Config::get("constants.CACHE_60"),function () {
            $childrenArray = array_reverse($this->children->toArray());
            if ($this->getGrandParent()) {

                if ($this->getGrandParent()->producttype_id == Config::get("constants.PRODUCT_TYPE_SELECTABLE")) {
                    $myName = $this->getGrandParent()->name . " - " . $this->name;
                    if (!empty($childrenArray))
                        $myName .= " : ";
                    $lastChild = last($childrenArray);
                    foreach ($childrenArray as $child) {
                        $myName .= $child->name;
                        if ($child->id != $lastChild->id)
                            $myName .= " - ";
                    }
                    return $myName;
                } else {
                    return $this->name;
                }
            } else {
                return $this->name;
            }
        });

    }

    public function getGrandParent()
    {
        $key="product:getGrandParent:".$this->cacheKey();
        return Cache::remember($key,Config::get("constants.CACHE_60"),function () {
            $counter = 1;
            $parentsArray = array();
            $myProduct = $this;
            while ($myProduct->hasParents()) {
                $parentsArray = array_add($parentsArray, $counter++, $myProduct->parents->first());
                $myProduct = $myProduct->parents->first();
            }
            if (empty($parentsArray))
                return false;
            else
                return array_last($parentsArray);
        });

    }

    public function hasParents($depth = 1)
    {
        $key="product:hasParents:".$depth."-".$this->cacheKey();
        return Cache::remember($key,Config::get("constants.CACHE_60"),function () use($depth) {
            $counter = 0;
            $myProduct = $this;
            while (!$myProduct->parents->isEmpty()) {
                if ($counter >= $depth) break;
                $myProduct = $myProduct->parents->first();
                $counter++;
            }
            if ($myProduct->id == $this->id || $counter != $depth) return false;
            else return true;
        });

    }

    public function gifts()
    {
        return $this->belongsToMany('App\Product', 'product_product', 'p1_id', 'p2_id')
            ->withPivot('relationtype_id')
            ->join('productinterrelations', 'relationtype_id', 'productinterrelations.id')
            ->where("relationtype_id", Config::get("constants.PRODUCT_INTERRELATION_GIFT"));
    }

    public function getGifts()
    {
        $key="product:getGifts:".$this->cacheKey();
        return Cache::remember($key,Config::get("constants.CACHE_60"),function () {
            $gifts = collect();
            if ($this->hasGifts()) {
                foreach ($this->gifts as $gift) {
                    $gifts->push($gift);
                }
            }
            return $gifts;
        });

    }

    public function hasGifts()
    {
        $key="product:hasGifts:".$this->cacheKey();
        return Cache::remember($key,Config::get("constants.CACHE_60"),function () {
            if ($this->gifts->isEmpty())
                return false;
            else
                return true;
        });

    }

    public function hasValidFiles($fileType)
    {
        $key="product:hasValidFiles:".$fileType.$this->cacheKey();
        return Cache::remember($key,Config::get("constants.CACHE_60"),function () use ($fileType){
            return !$this->validProductfiles($fileType)->get()->isEmpty();
        });

    }

    public function validProductfiles($fileType = "")
    {
        $product = $this;

        $files = $product->hasMany('\App\Productfile')
            ->where('enable', 1)
            ->where(function ($query) {
                $query->where('validSince', '<', Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())
                    ->timezone('Asia/Tehran'))
                    ->orwhereNull('validSince');
            })
            ->orderBy("order");
        if ($files->count() != 0 && strlen($fileType) > 0) {
            $fileTypeId = Productfiletype::all()->where("name", $fileType)->first();
            $files->where('productfiletype_id', $fileTypeId->id);
        }
        return $files;
    }

    public function attributevalueTree($attributeType = null)
    {
        $key="product:attributevalueTree:".$attributeType.$this->cacheKey();
        return Cache::remember($key,Config::get("constants.CACHE_60"),function () use ($attributeType){
            if ($attributeType) {
                $attributeType = Attributetype::all()->where("name", $attributeType)->first();
                $attributesArray = array();
                foreach ($this->attributeset->attributes()->where("attributetype_id", $attributeType->id) as $attribute) {
                        array_push($attributesArray, $attribute->id);
                }
            }
            $parentArray = $this->makeParentArray($this) ;
            array_push($parentArray, $this);
            $attributes = collect();
            foreach ($parentArray as $parent) {
                if (isset($attributesArray))
                    $attributevalues = $parent->attributevalues->whereIn("attribute_id", $attributesArray);
                else
                    $attributevalues = $parent->attributevalues;
                foreach ($attributevalues as $attributevalue) {
                    if (!$attributes->has($attributevalue->id))
                        $attributes->put($attributevalue->id, ["attributevalue" => $attributevalue, "attribute" => $attributevalue->attribute]);
                }
            }
            return $attributes;
        });

    }

    public function scopeEnable($query)
    {
        return $query->where('enable', '=', 1);
    }

    public function scopeConfigurable($query)
    {
        return $query->where('producttype_id', '=', 2);
    }

    public function scopeSimple($query)
    {
        return $query->where('producttype_id', '=', 1);
    }

    public function title()
    {
        if (isset($this->slogan) && strlen($this->slogan) > 0)
            return $this->name . ":" . $this->slogan;
        else return $this->name;
    }

    public function bons()
    {
        return $this->belongsToMany('\App\Bon')->withPivot('discount', 'bonPlus');
    }

    public function BoneName($bonName){
        $key="product:BoneName:".$this->cacheKey()."-bone:".$bonName;
        return Cache::remember($key,Config::get("constants.CACHE_60"),function () use ($bonName){
            return $this->bons->where("name", $bonName)->where("isEnable", 1);
        });

    }

    public function calculateBonPlus($bonId)
    {
        $key="product:calculateBonPlus:".$bonId.$this->cacheKey();
        return Cache::remember($key,Config::get("constants.CACHE_60"),function () use ($bonId){
            $bonPlus = 0;
            $bonPlus += $this->bons->where("id", $bonId)->sum("pivot.bonPlus");
            if ($bonPlus == 0) {
                $parentsArray = $this->makeParentArray($this);
                if (!empty($parentsArray)) {
                    foreach ($parentsArray as $parent) {
                        $bonPlus += $parent->bons->where("id", $bonId)->sum("pivot.bonPlus");
                    }
                }
            }
            return $bonPlus;
        });

    }

    public function coupons()
    {
        return $this->belongsToMany('App\Coupon');
    }

    public function productfiles()
    {
        return $this->hasMany('\App\Productfile');
    }

    public function photos()
    {
        return $this->hasMany('\App\Productphoto');
    }

    public function validateProduct()
    {
        if (!$this->enable)
            return "محصول مورد نظر غیر فعال است";
        elseif (isset($this->amount) && $this->amount >= 0)
            return "محصول مورد نظر تمام شده است";
        elseif (isset($this->validSince) && Carbon::now() < $this->validSince)
            return "تاریخ شروع سفارش محصول مورد نظر آغاز نشده است";
        elseif (isset($this->validUntil) && Carbon::now() > $this->validUntil)
            return "تاریخ سفارش محصول مورد نظر  به پایان رسیده است";
        else return "";
    }

    public function hasComplimentaries()
    {
        $key="product:hasComplimentaries:".$this->cacheKey();
        return Cache::remember($key,Config::get("constants.CACHE_60"),function () {
            return !$this->complimentaryproducts()->get()->isEmpty();
        });

    }

    public function complimentaryproducts()
    {
        return $this->belongsToMany('App\Product', 'complimentaryproduct_product', 'product_id', 'complimentary_id');
    }

    public function calculatePayablePrice(User $user = null)
    {
        if(isset($user))
            $costArray = $this->obtainProductCost($user);
        else
            $costArray = $this->obtainProductCost( );
        array_push($costArray, []);
        return $costArray;
    }

    /**
     * Obtain order total cost
     *
     * @param bool $withBon
     * @param \App\User $intendedUser
     * @return array
     */
    private function obtainProductCost(User $intendedUser = null)
    {

        if (isset($intendedUser))
            $user = $intendedUser;
        elseif (Auth::check())
            $user = Auth::user();
        else
            $user = null;

        $key="product:obtainProductCost:".$this->cacheKey()."-user:".(isset($user) ? $user->cacheKey() : "");

        return Cache::remember($key,Config::get("constants.CACHE_3"),function () use($user)  {
            // Obtaining discount
            $bonDiscount = 0;
            $productDiscount = 0;
            $productDiscountAmount = 0;
            $bonName = Config::get("constants.BON1");

            $totalBonNumber = 0;
            if (isset($user)) {
                $totalBonNumber = $user->userHasBon($bonName);
                $bons = $this->BoneName($bonName);
                if ($bons->isEmpty()) {
                    $parentsArray = $this->makeParentArray($this);

                    if (!empty($parentsArray)) {
                        foreach ($parentsArray as $parent) {
                            $bons = $parent->BoneName($bonName);
                            if (!$bons->isEmpty())
                                break;
                        }
                    }
                }
                if ($bons->isNotEmpty()) {
                    $bonDiscount += $bons->first()->pivot->discount * $totalBonNumber;
                }
            }

            //////////////////////////////

            $cost = 0;
            //Adding product base price

            if ($this->hasChildren()) {
                if ($this->basePrice == 0) {
                    $children = $this->children;
                    $childBonDiscount = 0;
                    foreach ($children as $child) {
                        if ($bonDiscount == 0) {
                            $childBons = $child->bons->where("name", $bonName)->where("isEnable", 1);
                            if ($childBons->isNotEmpty())
                                $childBonDiscount += $childBons->first()->pivot->discount * $totalBonNumber;
                        }
                        $cost += $child->basePrice;
                        $productDiscountAmount += ($child->discount / 100) * $child->basePrice;
                    }
                    $bonDiscount = $childBonDiscount;
                } else {
                    $cost += $this->basePrice;
                    $productDiscount += $this->discount;
                }
            } else {
                if (isset($this->discount) && $this->discount > 0)
                    $productDiscount += $this->discount;
                elseif (!$this->parents->where("producttype_id", Config::get("constants.PRODUCT_TYPE_CONFIGURABLE"))->isEmpty() && isset($this->parents->first()->discount)) $productDiscount += $this->parents->first()->discount;
                if ($this->hasParents()) {
                    if ($this->basePrice != 0 && $this->basePrice != $this->parents->first()->basePrice)
                        $cost += $this->basePrice;
                    else  $cost += $this->parents->first()->basePrice;

                } else {
                    $cost += $this->basePrice;
                }
            }
            /////////////////////////////////

            // Adding attributes extra cost
            if ($this->producttype_id != Config::get("constants.PRODUCT_TYPE_CONFIGURABLE")) {
                $attributevalues = $this->attributevalues('main')->get();
                foreach ($attributevalues as $attributevalue) {
                    if (isset($attributevalue->pivot->extraCost)) $cost += $attributevalue->pivot->extraCost;
                }
            }

            //////////////////////////////

            return [
                "cost" => (int)$cost,
                "productDiscount" => $productDiscount,
                'bonDiscount' => $bonDiscount,
                "productDiscountAmount" => $productDiscountAmount,
                'CustomerCost' =>(int)(((int)$cost * (1 - ($productDiscount / 100))) * (1 - ($bonDiscount / 100)) - $productDiscountAmount)
            ];
        });
    }

    //TODO: issue #97
    public function hasChildren($depth = 1)
    {
        $key="product:hasChildren:".$depth.$this->cacheKey();
        return Cache::remember($key,Config::get("constants.CACHE_60"),function () use($depth){
            $counter = 0;
            $myProduct = $this;
            while ($myProduct->children->isNotEmpty()) {
                if ($counter >= $depth)
                    break;
                $myProduct = $myProduct->children->first();
                $counter++;
            }
            if ($myProduct->id == $this->id || $counter != $depth)
                return false;
            else return true;
        });
    }

    public function attributevalues($attributeType = null)
    {
        if (isset($attributeType)) {
            $attributeType = Attributetype::all()->where("name", $attributeType)->first();
            $attributesArray = array();
            $attributesArray = array();
            foreach ($this->attributeset->attributes()->where("attributetype_id", $attributeType->id) as $attribute) {
                array_push($attributesArray, $attribute->id);
            }
            return $this->belongsToMany('App\Attributevalue')->whereIn("attribute_id", $attributesArray)->withPivot("extraCost", "description");
        } else {
            return $this->belongsToMany('App\Attributevalue')->withPivot("extraCost", "description");
        }
    }

    /**
     * @return string
     * Converting Created_at field to jalali
     */
    public function CreatedAt_Jalali()
    {
        $helper = new Helper();
        $explodedDateTime = explode(" ", $this->created_at);
//        $explodedTime = $explodedDateTime[1] ;
        return $helper->convertDate($this->created_at, "toJalali");
    }

    /**
     * @return string
     * Converting Updated_at field to jalali
     */
    public function UpdatedAt_Jalali()
    {
        $helper = new Helper();
        $explodedDateTime = explode(" ", $this->updated_at);
//        $explodedTime = $explodedDateTime[1] ;
        return $helper->convertDate($this->updated_at, "toJalali");
    }

    /**
     * @return string
     * Converting Created_at field to jalali
     */
    public function validSince_Jalali()
    {
        $helper = new Helper();
        $explodedDateTime = explode(" ", $this->validSince);
//        $explodedTime = $explodedDateTime[1] ;
        return $helper->convertDate($this->validSince, "toJalali");
    }

    /**
     * @return string
     * Converting Created_at field to jalali
     */
    public function validUntil_Jalali()
    {
        $helper = new Helper();
        $explodedDateTime = explode(" ", $this->validUntil);
//        $explodedTime = $explodedDateTime[1] ;
        return $helper->convertDate($this->validUntil, "toJalali");
    }

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'products_index';
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        unset($array['basePrice']);
        unset($array['discount']);

        unset($array['discount']);
        unset($array['isFree']);
        unset($array['amount']);
        unset($array['image']);
        unset($array['file']);

        unset($array['introVideo']);
        unset($array['enable']);
        unset($array['order']);
        unset($array['producttype_id']);
        unset($array['attributeset_id']);
        unset($array['created_at']);
        unset($array['updated_at']);
        unset($array['validSince']);
        unset($array['validUntil']);

        return $array;
    }

    private function makeSimpleInfoAttributes(&$attributevalues, &$attribute, &$attributeType, Collection &$simpleInfoAttributes ){
        $infoAttributeArray = [];
        foreach ($attributevalues as $attributevalue) {

            array_push($infoAttributeArray, ["displayName" => $attribute->displayName, "name" => $attributevalue->name,"index" => $attributevalue->name, "value" => $attributevalue->id, "type" => $attributeType->name]);

        }
        if (!empty($infoAttributeArray))
            $simpleInfoAttributes->put($attribute->displayName, $infoAttributeArray);
    }
    private function makeSelectAttributes(&$attributevalues, &$result){
        foreach ($attributevalues as $attributevalue) {
            $attributevalueIndex = $attributevalue->name;
            if (isset($attributevalue->pivot->description) && strlen($attributevalue->pivot->description) > 0)
                $attributevalueIndex .= "( " . $attributevalue->pivot->description . " )";

            if (isset($attributevalue->pivot->extraCost)) {
                if ($attributevalue->pivot->extraCost > 0)
                    $attributevalueIndex .= "(+" . number_format($attributevalue->pivot->extraCost) . " تومان)";
                elseif ($attributevalue->pivot->extraCost < 0)
                    $attributevalueIndex .= "(-" . number_format($attributevalue->pivot->extraCost) . " تومان)";
            }

            $result = array_add($result, $attributevalue->id, $attributevalueIndex);
        }
    }

    public function getAllAttributes()
    {
        $product = $this;
        $key = 'product:'."getAllAttributes:".$product->id;

        return Cache::remember($key,Config::get("constants.CACHE_60"),function () use ($product){

            $selectCollection = collect();
            $groupedCheckboxCollection = collect();
            $extraSelectCollection = collect();
            $extraCheckboxCollection = collect();
            $simpleInfoAttributes = collect();
            $checkboxInfoAttributes = collect();
            $attributeset = $product->attributeset;
            $attributes = $attributeset->attributes();
            $productType = $product->producttype->id;
            if (!$product->relationLoaded('attributevalues'))
                $product->load('attributevalues');

            $attributes->load('attributetype','attributecontrol');

            foreach ( $attributes as $attribute) {
                $attributeType = $attribute->attributetype;
                $controlName = $attribute->attributecontrol->name;
                $attributevalues = $product->attributevalues->where("attribute_id", $attribute->id)->sortBy("pivot.order");

                if (!$attributevalues->isEmpty()) {
                    switch ($controlName) {
                        case "select":
                            if($attributeType->name == "extra"){
                                $select = array();
                                $this->makeSelectAttributes($attributevalues,$select);
                                if (!empty($select))
                                    $extraSelectCollection->put($attribute->id, ["attributeDescription" => $attribute->displayName, "attributevalues" => $select]);

                            }elseif($attributeType->name == "main"&&  $productType == Config::get("constants.PRODUCT_TYPE_CONFIGURABLE")){
                                if ($attributevalues->count() == 1) {
                                    $this->makeSimpleInfoAttributes($attributevalues,$attribute,$attributeType,$simpleInfoAttributes);
                                } else {
                                    $select = array();
                                    $this->makeSelectAttributes($attributevalues,$select);
                                    if (!empty($select))
                                        $selectCollection->put($attribute->pivot->description, $select);
                                }
                            }
                            else{ // 1
                                $this->makeSimpleInfoAttributes($attributevalues,$attribute,$attributeType,$simpleInfoAttributes);
                            }
                            break;
                        case "groupedCheckbox":
                            if($attributeType->name == "extra"){
                                $groupedCheckbox = collect();
                                foreach ($attributevalues as $attributevalue) {
                                    $attributevalueIndex = $attributevalue->name;
                                    if (isset($attributevalue->pivot->description) && strlen($attributevalue->pivot->description) > 0)
                                        $attributevalueIndex .= "( " . $attributevalue->pivot->description . " )";

                                    if (isset($attributevalue->pivot->extraCost)) {
                                        if ($attributevalue->pivot->extraCost > 0)
                                            $attributevalueIndex .= "(+" . number_format($attributevalue->pivot->extraCost) . " تومان)";
                                        if ($attributevalue->pivot->extraCost < 0)
                                            $attributevalueIndex .= "(-" . number_format($attributevalue->pivot->extraCost) . " تومان)";
                                    }

                                    $groupedCheckbox->put($attributevalue->id, ["index" => $attributevalueIndex,"value" => $attributevalue->id, "type" => $attributeType->name, "productType" => $product->producttype->name]);
                                }
                                if (!empty($groupedCheckbox))
                                    $extraCheckboxCollection->put($attribute->displayName, $groupedCheckbox);

                            }
                            else {
                                if ($product->producttype->id == Config::get("constants.PRODUCT_TYPE_CONFIGURABLE")) {
                                    if($attributeType->name == "information"){
                                        $this->makeSimpleInfoAttributes($attributevalues,$attribute,$attributeType,$checkboxInfoAttributes);
                                    }else {
                                        $groupedCheckbox = array();
                                        foreach ($attributevalues as $attributevalue) {
                                            $attributevalueIndex = $attributevalue->name;
                                            if (isset($attributevalue->pivot->description) && strlen($attributevalue->pivot->description) > 0)
                                                $attributevalueIndex .= "( " . $attributevalue->pivot->description . " )";

                                            $attributevalueExtraCost = "";
                                            $attributevalueExtraCostWithDiscount = "";
                                            if (isset($attributevalue->pivot->extraCost)) {
                                                if ($attributevalue->pivot->extraCost > 0) {
                                                    $attributevalueExtraCost = "+" . number_format($attributevalue->pivot->extraCost) . " تومان";
                                                    if ($product->discount > 0)
                                                        $attributevalueExtraCostWithDiscount = number_format("+" . $attributevalue->pivot->extraCost * (1 - ($product->discount / 100))) . " تومان";
                                                    else
                                                        $attributevalueExtraCostWithDiscount = 0;
                                                } elseif ($attributevalue->pivot->extraCost < 0) {
                                                    $attributevalueExtraCost = "-" . number_format($attributevalue->pivot->extraCost) . " تومان";
                                                    if ($product->discount > 0)
                                                        $attributevalueExtraCostWithDiscount = number_format("-" . $attributevalue->pivot->extraCost * (1 - ($product->discount / 100))) . " تومان";
                                                    else
                                                        $attributevalueExtraCostWithDiscount = 0;
                                                }

                                            }
                                            $groupedCheckbox = array_add($groupedCheckbox, $attributevalue->id, ["index" => $attributevalueIndex, "extraCost" => $attributevalueExtraCost, "extraCostWithDiscount" => $attributevalueExtraCostWithDiscount, "value" => $attributevalue->id, "type" => $attributeType->name, "productType" => $product->producttype->name]);
                                        }
                                        if (!empty($groupedCheckbox))
                                            $groupedCheckboxCollection->put($attribute->pivot->description, $groupedCheckbox);
                                    }
                                } else {
                                    $this->makeSimpleInfoAttributes($attributevalues,$attribute,$attributeType,$checkboxInfoAttributes);
                                }
                            }
                            break;
                        default:
                            break;
                    }
                }

            }

            return [
                "selectCollection" => $selectCollection,
                "groupedCheckboxCollection" => $groupedCheckboxCollection,
                "extraSelectCollection" => $extraSelectCollection,
                "extraCheckboxCollection" => $extraCheckboxCollection,
                "simpleInfoAttributes" => $simpleInfoAttributes,
                "checkboxInfoAttributes" => $checkboxInfoAttributes,
            ];

        });

    }

    public function getRootImage()
    {
        $key="product:getRootImage:".$this->cacheKey();
        return Cache::remember($key,Config::get("constants.CACHE_60"),function (){
            $image = "";
            $grandParent = $this->getGrandParent();
            if ($grandParent !== false) {
                if (isset($grandParent->image)) $image = $grandParent->image;
            } else {
                if (isset($this->image)) $image = $this->image;
            }
            return $image;
        });


    }

    public function isHappening()
    {
        $isHappening = false;
        $now = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran');
        if ($this->id == 183) {
            $productStartTime = Carbon::create(2018, 03, 03, 22, 47, 20, 'Asia/Tehran');
            $productEndTime = Carbon::create(2018, 03, 03, 23, 47, 20, 'Asia/Tehran');
            if ($now->between($productStartTime, $productEndTime)) $isHappening = 0;
            elseif ($now->diffInMinutes($productStartTime, false) > 0) $isHappening = $now->diffInMinutes($productStartTime, false);
            else $isHappening = $now->diffInMinutes($productEndTime, false);
        }
        return $isHappening;
    }

    public function isEnableToPurchase()
    {
        //ToDo : should be removed in future
        if (in_array($this->id, Config::get("constants.DONATE_PRODUCT"))) return true;
        $grandParent = $this->getGrandParent();
        if ($grandParent !== false) {
            if (!$grandParent->enable) return false;
        }

        if ($this->hasParents()) {
            if (!$this->parents()->first()->enable) return false;
        }

        if (!$this->enable) {
            return false;
        }
        return true;
    }

}
