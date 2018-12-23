<?php

namespace App;

use App\Classes\{Advertisable,
    Checkout\Alaa\AlaaProductPriceCalculator,
    FavorableInterface,
    SEO\SeoInterface,
    SEO\SeoMetaTagsGenerator,
    Taggable};
use App\Collection\ProductCollection;
use App\Traits\{APIRequestCommon, CharacterCommon, DateTrait, favorableTraits, Helper, ProductCommon, ModelTrackerTrait};
use Carbon\Carbon;
use Exception;
use Illuminate\Database\{Eloquent\Builder, Eloquent\Model, Eloquent\SoftDeletes};
use Illuminate\Support\{Collection, Facades\Cache, Facades\Config};

/**
 * App\Product
 *
 * @property int                                                                 $id
 * @property string|null                                                         $name               نام  کالا
 * @property int                                                                 $basePrice          قیمت پایه  کالا
 * @property float                                                               $discount           میزان تخفیف کالا
 *           برای همه به درصد
 * @property int                                                                 $isFree             رایگان بودن یا
 *           نبودن محصول
 * @property int|null                                                            $amount             تعدا موجود از این
 *           محصول - نال به معنای بینهایت است
 * @property string|null                                                         $shortDescription   توضیحات مختصر کالا
 * @property string|null                                                         $longDescription    توضیحات کالا
 * @property string|null                                                         $specialDescription توضیحات خاص برای
 *           محصول
 * @property string|null                                                         $tags               تگ ها
 * @property string|null                                                         $slogan             یک جمله ی خاص
 *           درباره این کالا
 * @property string|null                                                         $image              تصویر اصلی کالا
 * @property string|null                                                         $file               فایل مربوط به کالا
 * @property string|null                                                         $introVideo         فیلم معرفی محصول
 * @property string|null                                                         $validSince         تاریخ شروع فروش
 *           کالا
 * @property string|null                                                         $validUntil         تاریخ پایان فروش
 *           کالا
 * @property int                                                                 $enable             فعال بودن یا نبودن
 *           کالا
 * @property int                                                                 $order              ترتیب کالا - در
 *           صورت نیاز به استفاده
 * @property int|null                                                            $producttype_id     آی دی مشخص کننده
 *           نوع کالا
 * @property int|null                                                            $attributeset_id    آی دی مشخص کننده
 *           دسته صفتهای کالا
 * @property \Carbon\Carbon|null                                                 $created_at
 * @property \Carbon\Carbon|null                                                 $updated_at
 * @property \Carbon\Carbon|null                                                 $deleted_at
 * @property-read \App\Attributeset|null                                         $attributeset
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Attributevalue[] $attributevalues
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Bon[]            $bons
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Product[]        $children
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Product[]        $complimentaryproducts
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Coupon[]         $coupons
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Product[]        $gifts
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Orderproduct[]   $orderproducts
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Product[]        $parents
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Productphoto[]   $photos
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Productfile[]    $productfiles
 * @property-read \App\Producttype|null                                          $producttype
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product configurable()
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Product onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product simple()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereAttributesetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereBasePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereIntroVideo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereIsFree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereLongDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereProducttypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereSlogan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereSpecialDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereValidSince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereValidUntil($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Product withoutTrashed()
 * @mixin \Eloquent
 * @property string|null $page_view
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product wherePageView($value)
 * @property string|null $redirectUrl آدرسی که صفحه محصول به آن به صورت همیشگی ریدایرکت می شود
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereRedirectUrl($value)
 * @property-read \App\Collection\UserCollection|\App\User[] $favoriteBy
 * @property-read mixed $photo
 * @property-read null|string $price_text
 * @property-read mixed $sample_photos
 * @property-write mixed $long_description
 * @property-write mixed $short_description
 * @property-write mixed $special_description
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product enable()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product valid()
 */
class Product extends Model implements Advertisable, Taggable, SeoInterface, FavorableInterface
{
    /*
    |--------------------------------------------------------------------------
    | Traits
    |--------------------------------------------------------------------------
    */

    use SoftDeletes;
    //    use Searchable;
    use ProductCommon;
    use CharacterCommon;
    use Helper;
    use APIRequestCommon;
    use DateTrait;
    use favorableTraits;
    use ModelTrackerTrait;

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    public const DONATE_PRODUCT        = [180];
    public const CUSTOM_DONATE_PRODUCT = 182;

    public const AMOUNT_LIMIT               = [
        'نامحدود',
        'محدود',
    ];
    public const ENABLE_STATUS              = [
        'نامحدود',
        'محدود',
    ];
    public const EXCLUSIVE_RELATED_PRODUCTS = [
    ];

    public const EXCLUDED_RELATED_PRODUCTS = [
        110,
        112,
        104,
        91,
        92,
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
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
        'specialDescription',
        'redirectUrl',
    ];

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = [
        'producttype',
        'attributeset',
        //        'validProductfiles',
        'bons',
        'attributevalues',
        'gifts',
    ];

    /*
    |--------------------------------------------------------------------------
    | overwrite methods
    |--------------------------------------------------------------------------
    */

    public static function getDonateProductCost()
    {
        return Product::find(self::DONATE_PRODUCT[0])->basePrice;
    }

    /**
     * Gets specific number of products
     *
     * @param $number
     *
     * @return $this
     */
    public static function recentProducts($number)
    {
        return self::getProducts(0, 1)
                   ->take($number)
                   ->orderBy('created_at', 'Desc');
    }

    /*
    |--------------------------------------------------------------------------
    | Private Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Gets desirable products
     *
     * @param int    $configurable
     * @param int    $enable
     * @param array  $excluded
     * @param string $orderBy
     * @param string $orderMethod
     *
     * @return $this|Product|Builder
     */
    public static function getProducts($configurable = 0, $enable = 0, $excluded = [], $orderBy = "", $orderMethod = "")
    {
        if ($configurable == 1) {
            $products = Product::configurable();
            if ($enable == 1)
                $products = $products->enable();
        } else if ($configurable == 0) {
            $products = Product::select()
                               ->doesntHave('parents')
                               ->whereNull('deleted_at');
            if ($enable == 1)
                $products->enable();
        }

        if (!empty($excluded))
            optional($products)->whereNotIn("id", $excluded);

        //ToDo do it via in product search class
        if (strlen($orderBy) > 0) {
            if (strlen($orderMethod) > 0) {
                switch ($orderMethod) {
                    case "asc" :
                        $products->orderBy("order");
                        break;
                    case "desc" :
                        $products->orderBy("order", "desc");
                        break;
                    default:
                        break;
                }
            } else {
                $products->orderBy("order");
            }
        }

        return $products;
    }

    /*
    |--------------------------------------------------------------------------
    |  Cache
    |--------------------------------------------------------------------------
    */

    /**
     * @return ProductCollection
     */
    public static function getExclusiveOtherProducts(): ProductCollection
    {
        $exclusiveOtherProductIds = self::EXCLUSIVE_RELATED_PRODUCTS;

        $key = "product:exclusiveOtherProducts:" . md5(implode(",", $exclusiveOtherProductIds));
        $exclusiveOtherProducts = Cache::remember($key, config("constants.CACHE_600"), function () use ($exclusiveOtherProductIds) {
            return self::whereIn("id", $exclusiveOtherProductIds)
                       ->get();
        });

        return $exclusiveOtherProducts;
    }


    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array $models
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = [])
    {
        return new ProductCollection($models);
    }

    /**
     * Scope a query to only include active Products.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->enable()
                     ->valid();
    }

    /**
     * Scope a query to only include enable(or disable) Products.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEnable($query)
    {
        return $query->where('enable', '=', 1);
    }

    /**
     * Scope a query to only include configurable Products.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeConfigurable($query)
    {
        return $query->where('producttype_id', '=', 2);
    }

    /**
     * Scope a query to only include simple Products.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSimple($query)
    {
        return $query->where('producttype_id', '=', 1);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessor
    |--------------------------------------------------------------------------
    */

    /**
     * Scope a query to only include valid Products.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeValid($query)
    {
        $now = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())
            ->timezone('Asia/Tehran');

        return $query
            ->where(function ($q) use ($now) {
                $q->where('validSince', '<', $now)
                  ->orWhereNull('validSince');
            })
            ->where(function ($q) use ($now) {
                $q->where('validUntil', '>', $now)
                  ->orWhereNull('validUntil');
            });
    }

    /**
     * Gets product's all attributes
     *
     * @return array
     */
    public function getAllAttributes(): array
    {
        $product = $this;
        $key = 'product:' . "getAllAttributes:" . $product->id;

        return Cache::remember($key, Config::get("constants.CACHE_600"), function () use ($product) {

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

            $attributes->load('attributetype', 'attributecontrol');

            foreach ($attributes as $attribute) {
                $attributeType = $attribute->attributetype;
                $controlName = $attribute->attributecontrol->name;
                $attributevalues = $product->attributevalues->where("attribute_id", $attribute->id)
                                                            ->sortBy("pivot.order");

                if (!$attributevalues->isEmpty()) {
                    switch ($controlName) {
                        case "select":
                            if ($attributeType->name == "extra") {
                                $select = [];
                                $this->makeSelectAttributes($attributevalues, $select);
                                if (!empty($select))
                                    $extraSelectCollection->put($attribute->id, [
                                        "attributeDescription" => $attribute->displayName,
                                        "attributevalues"      => $select,
                                    ]);

                            } else if ($attributeType->name == "main" && $productType == Config::get("constants.PRODUCT_TYPE_CONFIGURABLE")) {
                                if ($attributevalues->count() == 1) {
                                    $this->makeSimpleInfoAttributes($attributevalues, $attribute, $attributeType, $simpleInfoAttributes);
                                } else {
                                    $select = [];
                                    $this->makeSelectAttributes($attributevalues, $select);
                                    if (!empty($select))
                                        $selectCollection->put($attribute->pivot->description, $select);
                                }
                            } else { // 1
                                $this->makeSimpleInfoAttributes($attributevalues, $attribute, $attributeType, $simpleInfoAttributes);
                            }
                            break;
                        case "groupedCheckbox":
                            if ($attributeType->name == "extra") {
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

                                    $groupedCheckbox->put($attributevalue->id, [
                                        "index"       => $attributevalueIndex,
                                        "value"       => $attributevalue->id,
                                        "type"        => $attributeType->name,
                                        "productType" => $product->producttype->name,
                                    ]);
                                }
                                if (!empty($groupedCheckbox))
                                    $extraCheckboxCollection->put($attribute->displayName, $groupedCheckbox);

                            } else {
                                if ($product->producttype->id == Config::get("constants.PRODUCT_TYPE_CONFIGURABLE")) {
                                    if ($attributeType->name == "information") {
                                        $this->makeSimpleInfoAttributes($attributevalues, $attribute, $attributeType, $checkboxInfoAttributes);
                                    } else {
                                        $groupedCheckbox = [];
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
                                                        $attributevalueExtraCostWithDiscount = number_format("+" . $attributevalue->pivot->extraCost * (1 - ($product->discount / 100))) . " تومان"; else
                                                        $attributevalueExtraCostWithDiscount = 0;
                                                } else if ($attributevalue->pivot->extraCost < 0) {
                                                    $attributevalueExtraCost = "-" . number_format($attributevalue->pivot->extraCost) . " تومان";
                                                    if ($product->discount > 0)
                                                        $attributevalueExtraCostWithDiscount = number_format("-" . $attributevalue->pivot->extraCost * (1 - ($product->discount / 100))) . " تومان"; else
                                                        $attributevalueExtraCostWithDiscount = 0;
                                                }

                                            }
                                            $groupedCheckbox = array_add($groupedCheckbox, $attributevalue->id, [
                                                "index"                 => $attributevalueIndex,
                                                "extraCost"             => $attributevalueExtraCost,
                                                "extraCostWithDiscount" => $attributevalueExtraCostWithDiscount,
                                                "value"                 => $attributevalue->id,
                                                "type"                  => $attributeType->name,
                                                "productType"           => $product->producttype->name,
                                            ]);
                                        }
                                        if (!empty($groupedCheckbox))
                                            $groupedCheckboxCollection->put($attribute->pivot->description, $groupedCheckbox);
                                    }
                                } else {
                                    $this->makeSimpleInfoAttributes($attributevalues, $attribute, $attributeType, $checkboxInfoAttributes);
                                }
                            }
                            break;
                        default:
                            break;
                    }
                }

            }

            return [
                "selectCollection"          => $selectCollection,
                "groupedCheckboxCollection" => $groupedCheckboxCollection,
                "extraSelectCollection"     => $extraSelectCollection,
                "extraCheckboxCollection"   => $extraCheckboxCollection,
                "simpleInfoAttributes"      => $simpleInfoAttributes,
                "checkboxInfoAttributes"    => $checkboxInfoAttributes,
            ];

        });
    }

    private function makeSelectAttributes(&$attributevalues, &$result)
    {
        foreach ($attributevalues as $attributevalue) {
            $attributevalueIndex = $attributevalue->name;
            if (isset($attributevalue->pivot->description) && strlen($attributevalue->pivot->description) > 0)
                $attributevalueIndex .= "( " . $attributevalue->pivot->description . " )";

            if (isset($attributevalue->pivot->extraCost)) {
                if ($attributevalue->pivot->extraCost > 0)
                    $attributevalueIndex .= "(+" . number_format($attributevalue->pivot->extraCost) . " تومان)";
                else if ($attributevalue->pivot->extraCost < 0)
                    $attributevalueIndex .= "(-" . number_format($attributevalue->pivot->extraCost) . " تومان)";
            }

            $result = array_add($result, $attributevalue->id, $attributevalueIndex);
        }
    }

    private function makeSimpleInfoAttributes(&$attributevalues, &$attribute, &$attributeType, Collection &$simpleInfoAttributes)
    {
        $infoAttributeArray = [];
        foreach ($attributevalues as $attributevalue) {

            array_push($infoAttributeArray, [
                "displayName" => $attribute->displayName,
                "name"        => $attributevalue->name,
                "index"       => $attributevalue->name,
                "value"       => $attributevalue->id,
                "type"        => $attributeType->name,
            ]);

        }
        if (!empty($infoAttributeArray))
            $simpleInfoAttributes->put($attribute->displayName, $infoAttributeArray);
    }

    /**
     * Gets product's root image (image from it's grand parent)
     *
     * @return string
     */
    public function getRootImage(): string
    {
        $key = "product:getRootImage:" . $this->cacheKey();
        return Cache::remember($key, Config::get("constants.CACHE_600"), function () {
            $image = "";
            $grandParent = $this->getGrandParent();
            if ($grandParent !== false) {
                if (isset($grandParent->image))
                    $image = $grandParent->image;
            } else {
                if (isset($this->image))
                    $image = $this->image;
            }
            return $image;
        });
    }

    public function cacheKey()
    {
        $key = $this->getKey();
        $time = isset($this->update) ? $this->updated_at->timestamp : $this->created_at->timestamp;
        return sprintf("%s-%s", //$this->getTable(),
                       $key, $time);
    }

    public function getGrandParent()
    {
        $key = "product:getGrandParent:" . $this->cacheKey();
        return Cache::remember($key, Config::get("constants.CACHE_60"), function () {
            $parentsArray = $this->makeParentArray($this);

            if (empty($parentsArray))
                return false;
            else
                return array_last($parentsArray);
        });

    }

    /** Determines whether this product has parent or not
     *
     * @param int $depth
     *
     * @return bool
     */
    public function hasParents($depth = 1): bool
    {
        $key = "product:hasParents:" . $depth . "-" . $this->cacheKey();
        return Cache::remember($key, Config::get("constants.CACHE_60"), function () use ($depth) {
            $counter = 0;
            $myProduct = $this;
            while (!$myProduct->parents->isEmpty()) {
                if ($counter >= $depth)
                    break;
                $myProduct = $myProduct->parents->first();
                $counter++;
            }
            if ($myProduct->id == $this->id || $counter != $depth)
                return false; else
                return true;
        });

    }

    /**
     * Makes product's title
     *
     * @return string
     */
    public function title(): string
    {
        if (isset($this->slogan) && strlen($this->slogan) > 0)
            return $this->name . ":" . $this->slogan; else
            return $this->name;
    }

    /**
     * Gets product's tags
     *
     * @param $value
     *
     * @return mixed
     */
    public function getTagsAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * @param User|null $user
     * @return null|string
     */
    public function getPriceTextAttribute(User $user = null): ?string
    {
        if($this->isFree)
            return 'رایگان';
        if($this->basePrice == 0)
            return  'تعیین قیمت: پس از انتخاب محصول';
        return number_format($this->calculatePayablePrice($user)['cost']) . ' ' . 'تومان';
    }
    public function getPhotoAttribute()
    {
        $productImage = $this->image ;
        $productImage = (isset($productImage[0]) ? route('image', ['category'=>'4','w'=>'256' , 'h'=>'256' ,  'filename' =>  $productImage ]) : '/acm/image/255x255.png');
        return $productImage;
    }

    /**
     * Gets product's meta tags array
     *
     * @return array
     */
    public function getMetaTags(): array
    {
        return [
            'title'       => $this->name,
            'description' => $this->shortDescription,
            'url'         => action('ProductController@show', $this),
            'canonical'   => action('ProductController@show', $this),
            'site'        => 'آلاء',
            'imageUrl'    => $this->image,
            'imageWidth'  => '338',
            'imageHeight' => '338',
            'tags'        => $this->tags,
            'seoMod'      => SeoMetaTagsGenerator::SEO_MOD_PRODUCT_TAGS,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Mutator
    |--------------------------------------------------------------------------
    */

    /**
     * @return ProductCollection
     */
    public function getOtherProducts(): ProductCollection
    {
        $key = "product:otherProducts:" . $this->cacheKey();
        $excludedProducts = self::EXCLUDED_RELATED_PRODUCTS;

        $otherProducts = Cache::remember($key, config("constants.CACHE_60"), function () use ($excludedProducts) {
            return $otherProducts = self::getProducts(0, 1, $excludedProducts, "created_at", "desc")
                                        ->where("id", "<>", $this->id)
                                        ->get();
        });
        return $otherProducts;
    }

    /**
     *
     */
    public function getDiscount()
    {

    }

    /**
     * Gets products total bons = also checks whether his parents have any bons or not
     *
     * @param $bonName
     *
     * @return Collection
     */
    public function getTotalBons($bonName): Collection
    {
        $bons = $this->getBons($bonName);
        if ($bons->isEmpty()) {
            $parentsArray = $this->makeParentArray($this);
            if (!empty($parentsArray)) {
                foreach ($parentsArray as $parent) {
                    // ToDo : It does not check parents in a hierarchy to the root
                    $bons = $parent->getBons($bonName);
                    if ($bons->isNotEmpty())
                        break;
                }
            }
        }
        return $bons;
    }

    /**
     * Gets product's bon collection and filters it by bon name and enable/disable
     *
     * @param string $bonName
     *
     * @return Collection
     */
    public function getBons($bonName = "", $enable = 1): Collection
    {
        $key = "product:BoneName:" . $this->cacheKey() . "-bone:" . $bonName;
        return Cache::remember($key, Config::get("constants.CACHE_600"), function () use ($bonName, $enable) {
            $bons = $this->bons();
            if (strlen($bonName) > 0)
                $bons = $bons->where("name", $bonName);

            if ($enable)
                $bons = $bons->enable();

            return $bons->get();
        });

    }

    /**
     * Converts content's validSince to Jalali
     *
     * @return string
     */
    public function validSince_Jalali(): string
    {
        $explodedDateTime = explode(" ", $this->validSince);
        //        $explodedTime = $explodedDateTime[1] ;
        return $this->convertDate($this->validSince, "toJalali");
    }

    /**
     * Converts content's validUntil to Jalali
     *
     * @return string
     */
    public function validUntil_Jalali(): string
    {
        $explodedDateTime = explode(" ", $this->validUntil);
        //        $explodedTime = $explodedDateTime[1] ;
        return $this->convertDate($this->validUntil, "toJalali");
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    /** Setter mutator for limit
     *
     * @param $value
     */
    public function setAmountAttribute($value): void
    {
        if ($value == 0) {
            $this->attributes["amount"] = null;
        }else {
            $this->attributes["amount"] = $value;
        }
    }

    /** Setter mutator for discount
     *
     * @param $value
     */
    public function setDiscountAttribute($value): void
    {
        if ($this->strIsEmpty($value)) {
            $this->attributes["discount"] = null;
        }
        else {
            $this->attributes["discount"] = $value;
        }
    }

    /** Setter mutator for discount
     *
     * @param $value
     */
    public function setShortDescriptionAttribute($value): void
    {
        if ($this->strIsEmpty($value)) {
            $this->attributes["shortDescription"] = null;
        }
        else{
            $this->attributes["shortDescription"] = $value;
        }
    }

    /** Setter mutator for discount
     *
     * @param $value
     */
    public function setLongDescriptionAttribute($value): void
    {
        if ($this->strIsEmpty($value)) {
            $this->attributes["longDescription"] = null;
        }
        else {
            $this->attributes["longDescription"] = $value;
        }
    }

    /** Setter mutator for discount
     *
     * @param $value
     */
    public function setSpecialDescriptionAttribute($value): void
    {
        if ($this->strIsEmpty($value)) {
            $this->attributes["specialDescription"] = null;
        }else {
            $this->attributes["specialDescription"] = $value;
        }
    }

    /** Setter mutator for order
     *
     * @param $value
     */
    public function setOrderAttribute($value): void
    {
        if ($this->strIsEmpty($value))
            $value = 0;

        if ($this->attributes["order"] != $value)
            self::shiftProductOrders($value);

        $this->attributes["order"] = $value;
    }

    /**
     *
     *
     * @param int $order
     *
     * @return void
     */
    public static function shiftProductOrders($order): void
    {
        $productsWithSameOrder = self::getProducts(0, 0)
                                     ->where("order", $order)
                                     ->get();
        foreach ($productsWithSameOrder as $productWithSameOrder) {
            $productWithSameOrder->order = $productWithSameOrder->order + 1;
            $productWithSameOrder->update();
        }
    }

    public function producttype()
    {
        return $this->belongsTo('App\Producttype')
                    ->withDefault();
    }

    public function attributeset()
    {
        return $this->belongsTo('App\Attributeset');
    }

    public function orderproducts()
    {
        return $this->hasMany('App\Orderproduct');
    }

    public function children()
    {
        return $this->belongsToMany('App\Product', 'childproduct_parentproduct', 'parent_id', 'child_id')
                    ->withPivot("isDefault", "control_id", "description", "parent_id")
                    ->with('children');
    }

    public function gifts()
    {
        return $this->belongsToMany('App\Product', 'product_product', 'p1_id', 'p2_id')
                    ->withPivot('relationtype_id')
                    ->join('productinterrelations', 'relationtype_id', 'productinterrelations.id')
                    ->where("relationtype_id", Config::get("constants.PRODUCT_INTERRELATION_GIFT"));
    }

    public function coupons()
    {
        return $this->belongsToMany('App\Coupon');
    }

    public function productfiles()
    {
        return $this->hasMany('\App\Productfile');
    }

    /*
    |--------------------------------------------------------------------------
    | Checkers (boolean)
    |--------------------------------------------------------------------------
    */

    public function getSamplePhotosAttribute()
    {
        $key = "product:SamplePhotos:" . $this->cacheKey();
        $productSamplePhotos = Cache::remember($key, config("constants.CACHE_60"), function () {
            return $this->photos()
                        ->enable()
                        ->get()
                        ->sortBy("order");
        });

        return $productSamplePhotos;
    }

    public function photos()
    {
        $photos = $this->hasMany('\App\Productphoto');
        return $photos;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function bons()
    {
        return $this->belongsToMany('\App\Bon')
                    ->withPivot('discount', 'bonPlus');
    }

    /**Determines whether this product has any gifts or not
     *
     * @return bool
     */
    public function hasGifts(): bool
    {
        $key = "product:hasGifts:" . $this->cacheKey();
        return Cache::remember($key, Config::get("constants.CACHE_60"), function () {
            if ($this->gifts->isEmpty())
                return false; else
                return true;
        });

    }

    //TODO: issue #97

    /**Determines whether this product has valid files or not
     *
     * @param $fileType
     *
     * @return bool
     */
    public function hasValidFiles($fileType): bool
    {
        $key = "product:hasValidFiles:" . $fileType . $this->cacheKey();
        return Cache::remember($key, Config::get("constants.CACHE_60"), function () use ($fileType) {
            return !$this->validProductfiles($fileType)
                         ->get()
                         ->isEmpty();
        });

    }

    public function validProductfiles($fileType = "", $getValid = 1)
    {
        $product = $this;

        $files = $product->hasMany('\App\Productfile')
                         ->getQuery()
                         ->enable();
        if ($getValid)
            $files->valid();

        $files->orderBy("order");


        if ($fileType == "video")
            $fileTypeId = Config::get("constants.PRODUCT_FILE_TYPE_VIDEO"); else if ($fileType == "pamphlet")
            $fileTypeId = Config::get("constants.PRODUCT_FILE_TYPE_PAMPHLET");

        if (isset($fileTypeId))
            $files->where('productfiletype_id', $fileTypeId);

        return $files;
    }

    /**Determines whether this product is available for purchase or not
     *
     * @return bool
     */
    public function isEnableToPurchase(): bool
    {
        $key = "product:isEnableToPurchase:" . $this->cacheKey();
        return Cache::remember($key, Config::get("constants.CACHE_600"), function () {

            //ToDo : should be removed in future
            if (in_array($this->id, self::DONATE_PRODUCT))
                return true;
            $grandParent = $this->getGrandParent();
            if ($grandParent !== false) {
                if (!$grandParent->enable)
                    return false;
            }

            if ($this->hasParents()) {
                if (!$this->parents()
                          ->first()->enable)
                    return false;
            }

            if (!$this->enable) {
                return false;
            }
            return true;
        });
    }

    public function parents()
    {
        return $this->belongsToMany('App\Product', 'childproduct_parentproduct', 'child_id', 'parent_id')
                    ->withPivot("isDefault", "control_id", "description");
    }

    /**Determines whether this product has any complimentaries or not
     *
     * @return bool
     */
    public function hasComplimentaries(): bool
    {
        $key = "product:hasComplimentaries:" . $this->cacheKey();
        return Cache::remember($key, Config::get("constants.CACHE_600"), function () {
            return !$this->complimentaryproducts()
                         ->get()
                         ->isEmpty();
        });

    }

    public function complimentaryproducts()
    {
        return $this->belongsToMany('App\Product', 'complimentaryproduct_product', 'product_id', 'complimentary_id');
    }

    public function isTaggableActive(): bool
    {
        if ($this->isActive() && isset($this->tags) && !empty($this->tags->tags)) {
            return true;
        }
        return false;
    }

    /**
     * Checks whether the product is active or not .
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return ($this->isEnable() && $this->isValid() ? true : false);
    }

    /*
    |--------------------------------------------------------------------------
    | Static methods
    |--------------------------------------------------------------------------
    */

    /**
     * Checks whether the product is enable or not .
     *
     * @return bool
     */
    public function isEnable(): bool
    {
        if ($this->enable)
            return true;
        return false;
    }

    /**
     * Checks whether the product is valid or not .
     *
     * @return bool
     */
    public function isValid(): bool
    {
        if (($this->validSince < Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())
                                       ->timezone('Asia/Tehran') || is_null($this->validSince)) && ($this->validUntil > Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())
                                                                                                                              ->timezone('Asia/Tehran') || is_null($this->validUntil)))
            return true;
        return false;
    }

    /**
     * Checks whether the product is in stock or not .
     *
     * @return bool
     */
    public function isInStock(): bool
    {
        $isInStock = false;
        if ($this->isLimited()) {
            if ($this->amount > 0) {
                $isInStock = true;
            }
        } else {
            $isInStock = true;
        }

        return $isInStock;

    }

    /**Determines whether ths product's amount is limited or not
     *
     * @return bool
     */
    public function isLimited(): bool
    {
        return isset($this->amount);
    }

    /**
     * Checks whether this product is free or not
     *
     * @return bool
     */
    public function isFree():bool{
        return ($this->isFree)?true:false;
    }

    /**
     *
     * Checks whether this product has this coupon or not
     * @param Coupon $coupon
     * @return bool
     */
    public function hasThisCoupon(Coupon $coupon):bool
    {
        $flag = true;
        if (!in_array($coupon->id, $this->coupons->pluck('id')->toArray())) {
            $flag = false;
            $parentsArray = $this->makeParentArray($this);
            foreach ($parentsArray as $parent) {
                if (in_array($coupon->id, $parent->coupons->pluck('id')->toArray())) {
                    $flag = true;
                    break;
                }
            }
        }

        return $flag;
    }

    /**
     * Checks whether this product has this bon or not
     *
     * @param $bonId
     * @return bool
     */
    public function hasBon($bonId)
    {
        return $this->bons->where("id" , $bonId)->isNotEmpty();
    }

    /*
    |--------------------------------------------------------------------------
    | Other
    |--------------------------------------------------------------------------
    */

    public function getGifts()
    {
        $key = "product:getGifts:" . $this->cacheKey();
        return Cache::remember($key, Config::get("constants.CACHE_60"), function () {
            $gifts = collect();
            $gifts = $gifts->merge($this->gifts);

            $grandParent = $this->getGrandParent();
            if ($grandParent !== false) {
                $gifts = $gifts->merge($grandParent->gifts);
            }

            $allChildren =  $this->getAllChildren();
            foreach ($allChildren as $child)
            {
                $gifts = $gifts->merge($child->gifts);
            }

            return $gifts;
        });
    }

    public function attributevalueTree($attributeType = null)
    {
        $key = "product:attributevalueTree:" . $attributeType . $this->cacheKey();
        return Cache::remember($key, Config::get("constants.CACHE_60"), function () use ($attributeType) {
            if ($attributeType) {
                $attributeType = Attributetype::all()
                                              ->where("name", $attributeType)
                                              ->first();
                $attributesArray = [];
                foreach ($this->attributeset->attributes()
                                            ->where("attributetype_id", $attributeType->id) as $attribute) {
                    array_push($attributesArray, $attribute->id);
                }
            }
            $parentArray = $this->makeParentArray($this);
            array_push($parentArray, $this);
            $attributes = collect();
            foreach ($parentArray as $parent) {
                if (isset($attributesArray))
                    $attributevalues = $parent->attributevalues->whereIn("attribute_id", $attributesArray);
                else
                    $attributevalues = $parent->attributevalues;
                foreach ($attributevalues as $attributevalue) {
                    if (!$attributes->has($attributevalue->id))
                        $attributes->put($attributevalue->id, [
                            "attributevalue" => $attributevalue,
                            "attribute"      => $attributevalue->attribute,
                        ]);
                }
            }
            return $attributes;
        });

    }

    public function calculateBonPlus($bonId)
    {
        $key = "product:calculateBonPlus:" . $bonId . $this->cacheKey();
        return Cache::remember($key, Config::get("constants.CACHE_600"), function () use ($bonId) {
            $bonPlus = 0;
            $bonPlus += $this->bons->where("id", $bonId)
                                   ->sum("pivot.bonPlus");
            if ($bonPlus == 0) {
                $parentsArray = $this->makeParentArray($this);
                if (!empty($parentsArray)) {
                    foreach ($parentsArray as $parent) {
                        $bonPlus += $parent->bons->where("id", $bonId)
                                                 ->sum("pivot.bonPlus");
                    }
                }
            }
            return $bonPlus;
        });

    }

    public function validateProduct()
    {
        if (!$this->enable)
            return "محصول مورد نظر غیر فعال است";
        else if (isset($this->amount) && $this->amount >= 0)
            return "محصول مورد نظر تمام شده است";
        else if (isset($this->validSince) && Carbon::now() < $this->validSince)
            return "تاریخ شروع سفارش محصول مورد نظر آغاز نشده است";
        else if (isset($this->validUntil) && Carbon::now() > $this->validUntil)
            return "تاریخ سفارش محصول مورد نظر  به پایان رسیده است";
        else
            return "";
    }

    public function calculatePayablePrice(User $user = null)
    {
        $bonName = config("constants.BON1");
        $costArray = [];
        $costInfo = $this->obtainCostInfo($user);
        $costArray["cost"] = $costInfo->info->productCost;
        $costArray["customerPrice"] = $costInfo->price;
        $costArray["productDiscount"] = $costInfo->info->discount->info->product->info->percentageBase->percentage;
        $costArray["productDiscountValue"] = $costInfo->info->discount->info->product->info->percentageBase->decimalValue;
        $costArray["productDiscountAmount"] = $costInfo->info->discount->info->product->info->amount;
        $costArray["bonDiscount"] = $costInfo->info->discount->info->bon->info->$bonName->totalPercentage;
        $costArray["customerDiscount"] = $costInfo->info->discount->totalAmount;
        array_push($costArray, []);
        return $costArray;
    }

    /**
     * Obtains product's cost
     *
     * @param User|null $user
     *
     * @return
     */
    private function obtainCostInfo(User $user = null)
    {
        $key = "product:obtainCostInfo:" . $this->cacheKey() . "-user:" . (isset($user) ? $user->cacheKey() : "");

        return Cache::tags('bon')
                    ->remember($key, config("constants.CACHE_60"), function () use ($user) {
                        $cost = new AlaaProductPriceCalculator($this, $user);
                        return json_decode($cost->getPrice());
                    });
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

    public function isHappening()
    {
        $isHappening = false;
        $now = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())
                     ->timezone('Asia/Tehran');
        if ($this->id == 183) {
            $productStartTime = Carbon::create(2018, 03, 03, 22, 47, 20, 'Asia/Tehran');
            $productEndTime = Carbon::create(2018, 03, 03, 23, 47, 20, 'Asia/Tehran');
            if ($now->between($productStartTime, $productEndTime))
                $isHappening = 0;
            else if ($now->diffInMinutes($productStartTime, false) > 0)
                $isHappening = $now->diffInMinutes($productStartTime, false);
            else
                $isHappening = $now->diffInMinutes($productEndTime, false);
        }
        return $isHappening;
    }

    /**
     * @return Collection
     * @throws Exception
     */
    public function getAddItems(): Collection
    {
        // TODO: Implement getAddItems() method.
        throw new Exception("product Advertisable should be impediment");
    }

    public function retrievingTags()
    {
        /**
         *      Retrieving Tags
         */
        $response = $this->sendRequest(
            config("constants.TAG_API_URL") . "id/product/" . $this->id,
            "GET"
        );

        if ($response["statusCode"] == 200) {
            $result = json_decode($response["result"]);
            $tags = $result->data->tags;
        } else {
            $tags = [];
        }

        return $tags;
    }

    /**
     * @param $productFileTypes
     *
     * @return Collection
     */
    public function productFileTypesOrder(): collection
    {
        $defaultProductFileOrders = collect();
        $productFileTypes = Productfiletype::pluck('displayName', 'id')
                                           ->toArray();

        foreach ($productFileTypes as $key => $productFileType) {
            $lastProductFile = $this->validProductfiles($key, 0)
                                    ->get()
                                    ->first();
            if (isset($lastProductFile)) {
                $lastOrderNumber = $lastProductFile->order + 1;
                $defaultProductFileOrders->push([
                                                    "fileTypeId" => $key,
                                                    "lastOrder"  => $lastOrderNumber,
                                                ]);
            } else {
                $defaultProductFileOrders->push([
                                                    "fileTypeId" => $key,
                                                    "lastOrder"  => 1,
                                                ]);
            }
        }
        return $defaultProductFileOrders;
    }

    /** Equalizing this product's children to him
     */
    public function equalizingChildrenPrice(): void
    {
        if ($this->hasChildren()) {
            foreach ($this->children as $child) {
                $child->basePrice = $this->basePrice;
                $child->update();
            }
        }
    }

    /**Determines whether this product has any children or not
     *
     * @param int $depth
     *
     * @return bool
     */
    public function hasChildren($depth = 1): bool
    {
        $key = "product:hasChildren:" . $depth . $this->cacheKey();
        return Cache::remember($key, Config::get("constants.CACHE_600"), function () use ($depth) {
            $counter = 0;
            $myProduct = $this;
            while ($myProduct->children->isNotEmpty()) {
                if ($counter >= $depth)
                    break;
                $myProduct = $myProduct->children->first();
                $counter++;
            }
            if ($myProduct->id == $this->id || $counter != $depth)
                return false; else
                return true;
        });
    }

    /**
     * @return string
     */
    public function makeProductLink(): string
    {
        $key = "product:makeProductLink:" . $this->cacheKey();
        return Cache::remember($key, Config::get("constants.CACHE_60"), function () {
            $link = "";
            $grandParent = $this->getGrandParent();
            if ($grandParent !== false) {
                if ($grandParent->enable)
                    $link = action("ProductController@show", $this->getGrandParent());
            } else {
                if ($this->enable)
                    $link = action("ProductController@show", $this);
            }
            return $link;
        });

    }

    /** Makes an array of files with specific type
     *
     * @param Product $product
     * @param string  $type
     *
     * @return array
     */
    public function makeFileArray($type): array
    {
        $filesArray = [];
        $productsFiles = $this->validProductfiles($type)
                              ->get();
        foreach ($productsFiles as $productfile) {
            array_push($filesArray, [
                "file"       => $productfile->file,
                "name"       => $productfile->name,
                "product_id" => $productfile->product_id,
            ]);
        }

        return $filesArray;
    }

    public function getTaggableTags()
    {
        return $this->tags->tags;
    }

    public function getTaggableId(): int
    {
        return $this->id;
    }

    public function getTaggableScore()
    {
        return optional($this->created_at)->timestamp;
    }

    /**
     * Obtains product's price (rawCost)
     *
     * @return int
     */
    public function obtainPrice()
    {
        $cost = 0;
        if(!$this->isFree())
            if ($this->hasParents()) {
                $grandParent = $this->getGrandParent();
                $grandParentProductType = $grandParent->producttype_id;
                if ($grandParentProductType == config("constants.PRODUCT_TYPE_CONFIGURABLE")) {
                    if ($this->basePrice != 0 && $this->basePrice != $grandParent->basePrice)
                        $cost += $this->basePrice;
                    else
                        $cost += $grandParent->basePrice;
                } else if ($grandParentProductType == config("constants.PRODUCT_TYPE_SELECTABLE")) {
                    if ($this->basePrice == 0) {
                        $children = $this->children;
                        foreach ($children as $child) {
                            $cost += $child->basePrice;
                        }
                    } else {
                        $cost += $this->basePrice;
                    }
                }
            } else {
                $cost += $this->basePrice;
            }

        // Adding attributes extra cost
        $attributevalues = $this->attributevalues('main')->get();
        foreach ($attributevalues as $attributevalue) {
            if (isset($attributevalue->pivot->extraCost))
                $cost += $attributevalue->pivot->extraCost;
        }

        return $cost;
    }

    public function attributevalues($attributeType = null)
    {
        if (isset($attributeType)) {
            $attributeType = Attributetype::all()
                                          ->where("name", $attributeType)
                                          ->first();
            $attributesArray = [];
            foreach ($this->attributeset->attributes()
                                        ->where("attributetype_id", $attributeType->id) as $attribute) {
                array_push($attributesArray, $attribute->id);
            }
            return $this->belongsToMany('App\Attributevalue')
                        ->whereIn("attribute_id", $attributesArray)
                        ->withPivot("extraCost", "description");
        } else {
            return $this->belongsToMany('App\Attributevalue')
                        ->withPivot("extraCost", "description");
        }
    }

    /**
     * Obtains discount value base on product parents
     *
     * @return float
     */
    public function getFinalDiscountValue()
    {
        $discount = 0;
        if ($this->hasParents()) {
            $parent = $this->parents->first();
            $parentProductType = $parent->producttype_id;
            if ($parentProductType == config("constants.PRODUCT_TYPE_CONFIGURABLE")) {
                if ($this->discount > 0)
                    $discount += $this->discount;
                else if ($parent->discount > 0)
                    $discount += $this->parents->first()->discount;
            } else if ($parentProductType == config("constants.PRODUCT_TYPE_SELECTABLE")) {
                if ($this->basePrice != 0) {
                    $discount = $this->discount;
                }
            }
        } else {
            $discount = $this->discount;
        }

        return $discount;
    }

    /**
     * Obtains product's discount percentage
     *
     * @return float|int
     */
    public function obtainDiscount()
    {
        $discount = $this->getFinalDiscountValue();
        return $discount / 100;
    }

    /**
     * Obtains product's bon discount percentage
     *
     * @param $bonName
     *
     * @return float|int
     */
    public function obtainBonDiscount($bonName)
    {
        $discount = 0;
        $bons = $this->getBons($bonName);
        if ($bons->isEmpty()) {
            $parentsArray = $this->makeParentArray($this);
            if (!empty($parentsArray)) {
                foreach ($parentsArray as $parent) {
                    // ToDo : It does not check parents in a hierarchy to the root
                    $bons = $parent->getBons($bonName);
                    if ($bons->isNotEmpty()) {
                        $bon = $bons->first();
                        $discount = $bon->pivot->discount;
                        break;
                    }
                }
            }
        } else {
            $bon = $bons->first();
            $discount = $bon->pivot->discount;
        }
        return $discount / 100;
    }

    /**
     * Obtains product's discount amount in cash
     *
     * @return int
     */
    public function obtainDiscountAmount(): int
    {
        $discountAmount = 0;
        if ($this->hasParents()) {
            $parent = $this->parents->first();
            $parentProductType = $parent->producttype_id;
            if ($parentProductType == config("constants.PRODUCT_TYPE_SELECTABLE")) {
                if ($this->basePrice == 0) {
                    $children = $this->children;
                    foreach ($children as $child) {
                        $discountAmount += ($child->discount / 100) * $child->basePrice;
                    }
                }
            }
        }

        return $discountAmount;
    }

    /**
     * Disables the product
     *
     */
    public function disable():void
    {
        $this->enable = 0 ;
    }

    /**
     * Enables the product
     *
     */
    public function enable():void
    {
        $this->enable = 1;
    }

    /**
     * Gets a collection containing all of product children
     *
     * @return mixed
     */
    public function getAllChildren()
    {
        $key = "product:makeChildrenArray:" . $this->cacheKey();
        return Cache::remember($key, Config::get("constants.CACHE_0"), function () {
            $children = collect();
            if ($this->hasChildren()) {
                $thisChildren = $this->children;
                $children = $children->merge($thisChildren);
                foreach ($thisChildren as $child)
                {
                    $children = $children->merge($child->getAllChildren());
                }
            }
            return $children;
        });
    }

    /**
     * Makes a collection of product phoots
     *
     */
    public function getPhotos()
    {
        $photos = collect();
        $thisPhotos = $this->sample_photos;
        $photos = $photos->merge($thisPhotos);

        $allChildren =  $this->getAllChildren();
        foreach ($allChildren as $child)
        {
            $childPhotos = $child->sample_photos;
            $photos = $photos->merge($childPhotos);
        }

        return $photos;
    }
}
