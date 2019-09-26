<?php

namespace App;

use Exception;
use Carbon\Carbon;
use Illuminate\Database\{Eloquent\Builder};
use Laravel\Scout\Searchable;
use App\Collection\SetCollection;
use Kalnoy\Nestedset\QueryBuilder;
use App\Collection\ProductCollection;
use Illuminate\Support\{Collection, Facades\Auth, Facades\Cache};
use App\Classes\{Taggable,
    Advertisable,
    SEO\SeoInterface,
    FavorableInterface,
    SEO\SeoMetaTagsGenerator,
    Checkout\Alaa\AlaaProductPriceCalculator};
use App\Traits\{ProductCommon,
    favorableTraits,
    APIRequestCommon,
    ModelTrackerTrait,
    Product\ProductBonTrait,
    Product\ProductPhotoTrait,
    Product\TaggableProductTrait,
    Product\ProductAttributeTrait};

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
 * @property string|null                                                         $page_view
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product wherePageView($value)
 * @property string|null                                                         $redirectUrl        آدرسی که صفحه محصول به آن به صورت همیشگی ریدایرکت می شود
 * @method static Builder|Product whereRedirectUrl($value)
 * @method static Builder|Product enable()
 * @method static Builder|Product valid()
 * @property-read \App\Collection\UserCollection|\App\User[]                     $favoriteBy
 * @property-read mixed                                                          $photo
 * @property-read null|string                                                    $price_text
 * @property-read mixed                                                          $sample_photos
 * @property-write mixed                                                         $long_description
 * @property-write mixed                                                         $short_description
 * @property-write mixed                                                         $special_description
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product query()
 * @property int|null                                                            $grand_id
 * @property-read \Collection|null                                               $attributes
 * @property-read mixed                                                          $gift
 * @property-read mixed                                                          $grand_parent
 * @property-read mixed                                                          $type
 * @property-read mixed                                                          $url
 * @property-read \App\Product                                                   $grand
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereGrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                          $active
 * @property Product                                                             grandParent
 * @property-read mixed                                                          $api_url
 * @property-read array|string                                                   $price
 * @property-read mixed                                                          $redirect_url
 * @property-read \App\Collection\SetCollection|\App\Contentset[]                $sets
 * @property-read mixed                                                          $cache_cooldown_seconds
 * @property mixed block
 * @property \Illuminate\Support\Collection intro_videos
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product main()
 * @property int|null $block_id بلاک مرتبط با این محصول
 * @property string|null $intro_videos کلیپ های معرفی محصول
 * @property-read \App\Block|null $block
 * @property-read int|null $bons_count
 * @property-read int|null $children_count
 * @property-read int|null $complimentaryproducts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Contract[] $contracts
 * @property-read int|null $contracts_count
 * @property-read int|null $coupons_count
 * @property-read int|null $favorite_by_count
 * @property-read mixed $attribute_set
 * @property-read mixed $bon_discount
 * @property-read mixed $bon_plus
 * @property-read mixed $edit_link
 * @property-read mixed $intro_video
 * @property-read mixed $intro_video_thumbnail
 * @property-read mixed $jalali_created_at
 * @property-read mixed $jalali_updated_at
 * @property-read mixed $jalali_valid_since
 * @property-read mixed $jalali_valid_until
 * @property-read mixed $remove_link
 * @property-read int|null $gifts_count
 * @property-read int|null $orderproducts_count
 * @property-read int|null $parents_count
 * @property-read int|null $photos_count
 * @property-read int|null $productfiles_count
 * @property-read int|null $sets_count
 * @property mixed livedescriptions
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereBlockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereIntroVideos($value)
 */
class Product extends BaseModel implements Advertisable, Taggable, SeoInterface, FavorableInterface
{
    /*
    |--------------------------------------------------------------------------
    | Traits
    |--------------------------------------------------------------------------
    */

    use Searchable;
    use ProductCommon;
    use APIRequestCommon;
    use favorableTraits;
    use ModelTrackerTrait;
    use ProductAttributeTrait, ProductBonTrait, ProductPhotoTrait;
    use TaggableProductTrait;
    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */
    public const DONATE_PRODUCT_5_HEZAR = 180;

    public const CUSTOM_DONATE_PRODUCT = 182;

    public const ASIATECH_PRODUCT = 224;

    public const AMOUNT_LIMIT = [
        'نامحدود',
        'محدود',
    ];

    public const ENABLE_STATUS = [
        'غیرفعال',
        'فعال',
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
        'isFree',
        'specialDescription',
        'redirectUrl',
    ];

    protected $appends = [
        'gift',
        'url',
        'apiUrl',
        'type',
        'photo',
        'attributes',
        'samplePhotos',
        'price',
        'sets',
        'attributeSet',
        'jalaliValidSince',
        'jalaliValidUntil',
        'jalaliCreatedAt',
        'jalaliUpdatedAt',
        'bonPlus',
        'bonDiscount',
        'editLink',
        'removeLink',
        'children',
        'introVideo',
    ];

    protected $hidden = [
        'gifts',
        'basePrice',
        'discount',
        'grand_id',
        'producttype_id',
        'attributeset_id',
        'file',
        'specialDescription',
        'producttype',
        'validSince',
        'deleted_at',
        'validUntil',
        'image',
        'pivot',
        'created_at',
        'attributevalues',
        'grand',
        'productSet',
        'attributeset',
        'intro_videos',
        'block_id'
    ];

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = [
        'producttype',
        'attributeset',
        //      'validProductfiles',
        'bons',
        'attributevalues',
        'gifts',
    ];

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
     * @param  int     $configurable
     * @param  int     $enable
     * @param  array   $excluded
     * @param  string  $orderBy
     * @param  string  $orderMethod
     *
     * @return $this|Product|Builder
     */
    public static function getProducts($configurable = 0, $enable = 0, $excluded = [], $orderBy = '', $orderMethod = '')
    {
        /** @var Product $products */
        if ($configurable == 1) {
            $products = Product::configurable();
            if ($enable == 1) {
                $products = $products->enable();
            }
        } else {
            if ($configurable == 0) {
                $products = Product::select()
                    ->doesntHave('parents')
                    ->whereNull('deleted_at');
                if ($enable == 1) {
                    $products->enable();
                }
            }
        }

        if (!empty($excluded)) {
            optional($products)->whereNotIn('id', $excluded);
        }

        //ToDo do it via in product search class
        if (strlen($orderBy) > 0) {
            if (strlen($orderMethod) > 0) {
                switch ($orderMethod) {
                    case 'asc' :
                        $products->orderBy('order');
                        break;
                    case 'desc' :
                        $products->orderBy('order', 'desc');
                        break;
                    default:
                        break;
                }
            } else {
                $products->orderBy('order');
            }
        }

        return $products;
    }

    /**
     * @return \App\Collection\ProductCollection
     */
    public static function getProductsHaveBestOffer(): ProductCollection
    {
        return new ProductCollection();
        return Product::find([
            294,
            330,
            295,
            329,
            181,
            225,
            275,
            226,

        ]);
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = [])
    {
        return new ProductCollection($models);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Scope a query to only include active Products.
     *
     * @param  Builder  $query
     *
     * @return Builder
     */
    public function scopeActive($query)
    {
        /** @var Product $query */
        return $query->enable()
            ->valid();
    }

    /**
     * Scope a query to only include enable(or disable) Products.
     *
     * @param  Builder  $query
     *
     * @return Builder
     */
    public function scopeEnable($query)
    {
        return $query->where('enable', '=', 1);
    }

    /**
     * Scope a query to only include configurable Products.
     *
     * @param  Builder  $query
     *
     * @return Builder
     */
    public function scopeConfigurable($query)
    {
        return $query->where('producttype_id', '=', 2);
    }

    /**
     * Scope a query to only include simple Products.
     *
     * @param  Builder  $query
     *
     * @return Builder
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
     * @param  Builder  $query
     *
     * @return Builder
     */
    public function scopeValid($query)
    {
        $now = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())
            ->timezone('Asia/Tehran');

        return $query->where(function ($q) use ($now) {
            /** @var QueryBuilder $q */
            $q->where('validSince', '<', $now)
                ->orWhereNull('validSince');
        })
            ->where(function ($q) use ($now) {
                /** @var QueryBuilder $q */
                $q->where('validUntil', '>', $now)
                    ->orWhereNull('validUntil');
            });
    }

    /**
     * Makes product's title
     *
     * @return string
     */
    public function title(): string
    {
        if (isset($this->slogan) && strlen($this->slogan) > 0) {
            return $this->name.':'.$this->slogan;
        } else {
            return $this->name;
        }
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

    public function getRedirectUrlAttribute($value)
    {
        if ($value == null) {
            return $value;
        }
        $value = parse_url($value);

        return url($value['path']);
    }

    /**
     * @param User|null $user
     *
     * @return array
     */
    public function getPriceTextAttribute(): array
    {
        if ($this->isFree) {
            return 'رایگان';
        }

        $priceInfo = $this->price;

        if(is_null($priceInfo['base']))
            $basePriceText = 'پس از انتخاب محصول';
        else
            $basePriceText  = number_format($priceInfo['base']).' تومان';

        $finalPriceText = number_format($priceInfo['final']).' تومان';
        $customerDiscount = $priceInfo['discount'];

        return [
                'basePriceText'     => $basePriceText,
                'finalPriceText'    => $finalPriceText,
                'discount'          => $customerDiscount
            ];
    }

    public function calculatePayablePrice(User $user = null)
    {
        $bonName                            = config('constants.BON1');
        $costArray                          = [];
        $costInfo                           = $this->obtainCostInfo($user);
        $costArray['cost']                  = $costInfo->info->productCost;
        $costArray['customerPrice']         = $costInfo->price;
        $costArray['productDiscount']       = $costInfo->info->discount->info->product->info->percentageBase->percentage;
        $costArray['productDiscountValue']  = $costInfo->info->discount->info->product->info->percentageBase->decimalValue;
        $costArray['productDiscountAmount'] = $costInfo->info->discount->info->product->info->amount;
        $costArray['bonDiscount']           = $costInfo->info->discount->info->bon->info->$bonName->totalPercentage;
        $costArray['customerDiscount']      = $costInfo->info->discount->totalAmount;

        return $costArray;
    }

    /**
     * Obtains product's cost
     *
     * @param  User|null  $user
     *
     * @return mixed
     */
    private function obtainCostInfo(User $user = null)
    {
        $key = 'product:obtainCostInfo:'.$this->cacheKey().'-user:'.(isset($user) ? $user->cacheKey() : '');

        return Cache::tags(['product'])
            ->tags('bon')
            ->remember($key, config('constants.CACHE_60'), function () use ($user) {
                $cost = new AlaaProductPriceCalculator($this, $user);

                return json_decode($cost->getPrice());
            });
    }

    /**
     * @return array|string
     */
    public function getPriceAttribute()
    {
        //ToDo : Doesn't work for app
        $user = null;
        if(Auth::check())
            $user = Auth::user();

        $costArray     = $this->calculatePayablePrice($user);
        $cost          = $costArray['cost'];
        $customerPrice = $costArray['customerPrice'];
        if (isset($cost)) {
            return [
                'base'     => $cost,
                'discount' => $cost - $customerPrice,
                'final'    => $customerPrice,
            ];
        }

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | Mutator
    |--------------------------------------------------------------------------
    */

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
            'url'         => action('Web\ProductController@show', $this),
            'canonical'   => action('Web\ProductController@show', $this),
            'site'        => 'آلاء',
            'imageUrl'    => $this->image,
            'imageWidth'  => '338',
            'imageHeight' => '338',
            'tags'        => $this->tags,
            'seoMod'      => SeoMetaTagsGenerator::SEO_MOD_PRODUCT_TAGS,
        ];
    }

    /**
     * Converts content's validSince to Jalali
     *
     * @return string
     */
    public function validSince_Jalali(): string
    {
        /*$explodedDateTime = explode(" ", $this->validSince);*/
        //        $explodedTime = $explodedDateTime[1] ;
        return $this->convertDate($this->validSince, 'toJalali');
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    /**
     * Converts content's validUntil to Jalali
     *
     * @return string
     */
    public function validUntil_Jalali(): string
    {
        /*$explodedDateTime = explode(" ", $this->validUntil);*/
        //        $explodedTime = $explodedDateTime[1] ;
        return $this->convertDate($this->validUntil, 'toJalali');
    }

    /** Setter mutator for limit
     *
     * @param $value
     */
    public function setAmountAttribute($value): void
    {
        if ($value == 0) {
            $this->attributes['amount'] = null;
        } else {
            $this->attributes['amount'] = $value;
        }
    }

    /** Setter mutator for discount
     *
     * @param $value
     */
    public function setDiscountAttribute($value): void
    {
        if ($this->strIsEmpty($value)) {
            $this->attributes['discount'] = null;
        } else {
            $this->attributes['discount'] = $value;
        }
    }

    /** Setter mutator for discount
     *
     * @param $value
     */
    public function setShortDescriptionAttribute($value): void
    {
        if ($this->strIsEmpty($value)) {
            $this->attributes['shortDescription'] = null;
        } else {
            $this->attributes['shortDescription'] = $value;
        }
    }

    /** Setter mutator for discount
     *
     * @param $value
     */
    public function setLongDescriptionAttribute($value): void
    {
        if ($this->strIsEmpty($value)) {
            $this->attributes['longDescription'] = null;
        } else {
            $this->attributes['longDescription'] = $value;
        }
    }

    /** Setter mutator for discount
     *
     * @param $value
     */
    public function setSpecialDescriptionAttribute($value): void
    {
        if ($this->strIsEmpty($value)) {
            $this->attributes['specialDescription'] = null;
        } else {
            $this->attributes['specialDescription'] = $value;
        }
    }

    /** Setter mutator for order
     *
     * @param $value
     */
    public function setOrderAttribute($value = null): void
    {
        if ($this->strIsEmpty($value)) {
            $value = 0;
        }

        $this->attributes['order'] = $value;
    }

    /**
     * Set the content's tag.
     *
     * @param  array  $value
     *
     * @return void
     */
    public function setTagsAttribute(array $value = null)
    {
        $tags = null;
        if (!empty($value)) {
            $tags = json_encode([
                'bucket' => 'content',
                'tags'   => $value,
            ], JSON_UNESCAPED_UNICODE);
        }

        $this->attributes['tags'] = $tags;
    }

    /**
     * Set the product's thumbnail.
     *
     * @param  Collection  $input
     *
     * @return void
     */
    public function setIntroVideosAttribute(Collection $input = null)
    {
        $this->attributes['intro_videos'] = optional($input)->toJson(JSON_UNESCAPED_UNICODE);
    }


    public function producttype()
    {
        return $this->belongsTo(Producttype::class)
            ->withDefault();
    }

    public function attributeset()
    {
        return $this->belongsTo(Attributeset::class);
    }

    public function orderproducts()
    {
        return $this->hasMany(Orderproduct::class);
    }

    public function children()
    {
        return $this->belongsToMany(Product::class, 'childproduct_parentproduct', 'parent_id', 'child_id')
            ->withPivot('isDefault', 'control_id', 'description',
                'parent_id')
            ->with('children');
    }

    public function gifts()
    {
        return $this->belongsToMany(Product::class, 'product_product', 'p1_id', 'p2_id')
            ->withPivot('relationtype_id')
            ->join('productinterrelations',
                'relationtype_id', 'productinterrelations.id')
            ->where('relationtype_id', config('constants.PRODUCT_INTERRELATION_GIFT'));
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class);
    }

    public function block()
    {
        return $this->belongsTo(Block::class);
    }

    public function contracts(){
        return $this->hasMany(Contract::Class);
    }

    public function livedescriptions(){
        return $this->hasMany(LiveDescription::class);
    }


    /*
    |--------------------------------------------------------------------------
    | Checkers (boolean)
    |--------------------------------------------------------------------------
    */

    public function productfiles()
    {
        return $this->hasMany(Productfile::class);
    }

    //TODO: issue #97

    /**Determines whether this product has any gifts or not
     *
     * @return bool
     */
    public function hasGifts(): bool
    {
        $key = 'product:hasGifts:'.$this->cacheKey();

        return Cache::tags(['product'])
            ->remember($key, config('constants.CACHE_60'), function () {
                return ($this->gifts->isEmpty() ? false : true);
            });
    }

    /**Determines whether this product has valid files or not
     *
     * @param $fileType
     *
     * @return bool
     */
    public function hasValidFiles($fileType): bool
    {
        $key = 'product:hasValidFiles:'.$fileType.$this->cacheKey();

        return Cache::tags(['product'])
            ->remember($key, config('constants.CACHE_60'), function () use ($fileType) {
                return !$this->validProductfiles($fileType)
                    ->get()
                    ->isEmpty();
            });
    }

    /**
     * @param  string  $fileType
     * @param  int     $getValid
     *
     * @return
     */
    public function validProductfiles($fileType = '', $getValid = 1)
    {
        $product = $this;

        $files = $product->hasMany('\App\Productfile')
            ->enable();
        if ($getValid) {
            $files->valid();
        }
        $fileTypeId = [
                          'video'    => config('constants.PRODUCT_FILE_TYPE_VIDEO'),
                          'pamphlet' => config('constants.PRODUCT_FILE_TYPE_PAMPHLET'),
                          ''         => null,
                      ][$fileType];

        if (isset($fileTypeId)) {
            $files->where('productfiletype_id', $fileTypeId);
        }

        $files->orderBy('order');
        return $files;
    }

    /**
     * Scope a query to only include product without redirect url.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMain($query)
    {
        return $query->whereNull('redirectUrl');
    }

    /**Determines whether this product is available for purchase or not
     *
     * @return bool
     */
    public function isEnableToPurchase(): bool
    {
        $key = 'product:isEnableToPurchase:'.$this->cacheKey();

        return Cache::tags(['product'])
            ->remember($key, config('constants.CACHE_600'), function () {

                //ToDo : should be removed in future
                if (in_array($this->id, [
                    self::CUSTOM_DONATE_PRODUCT,
                    self::DONATE_PRODUCT_5_HEZAR,
                ])) {
                    return true;
                }
                $grandParent = $this->grandParent;
                if (isset($grandParent)) {
                    if (!$grandParent->enable) {
                        return false;
                    }
                }

                if ($this->hasParents()) {
                    if (!$this->parents()
                        ->first()->enable) {
                        return false;
                    }
                }

                if (!$this->enable) {
                    return false;
                }

                return true;
            });
    }

    /** Determines whether this product has parent or not
     *
     * @param  int  $depth
     *
     * @return bool
     */
    public function hasParents($depth = 1): bool
    {
        $key = 'product:hasParents:'.$depth.'-'.$this->cacheKey();

        return Cache::tags(['product'])
            ->remember($key, config('constants.CACHE_60'), function () use ($depth) {
                $counter  = 1;
                $myParent = $this->parents->first();
                while (isset($myParent)) {
                    if ($counter >= $depth) {
                        break;
                    }
                    $myParent = $myParent->parents->first();
                    $counter++;
                }
                if (!isset($myParent) || $counter != $depth) {
                    return false;
                } else {
                    return true;
                }
            });
    }

    public function parents()
    {
        return $this->belongsToMany(Product::class, 'childproduct_parentproduct', 'child_id', 'parent_id')
            ->withPivot('isDefault', 'control_id',
                'description')//                    ->with('parents')
            ;
    }

    public function migrationGrand()
    {
        $key = 'product:GrandParent:'.$this->cacheKey();

        return Cache::tags(['product'])
            ->remember($key, config('constants.CACHE_60'), function () {
                $parentsArray = $this->getAllParents();
                if ($parentsArray->isEmpty()) {
                    return false;
                }

                return $parentsArray->last();

            });
    }

    public function getGrandParentAttribute()
    {
        $key = 'product:GrandParent:'.$this->cacheKey();

        return Cache::tags(['product'])
            ->remember($key, config('constants.CACHE_60'), function () {
                return $this->grand;
            });
    }

    /**
     * Get the Grand parent record associated with the product.
     */
    public function grand()
    {
        return $this->hasOne(Product::class, 'id', 'grand_id');
    }

    /**Determines whether this product has any complimentaries or not
     *
     * @return bool
     */
    public function hasComplimentaries(): bool
    {
        $key = 'product:hasComplimentaries:'.$this->cacheKey();

        return Cache::tags(['product'])
            ->remember($key, config('constants.CACHE_600'), function () {
                return !$this->complimentaryproducts()
                    ->get()
                    ->isEmpty();
            });
    }

    public function complimentaryproducts()
    {
        return $this->belongsToMany(Product::class, 'complimentaryproduct_product', 'product_id', 'complimentary_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Static methods
    |--------------------------------------------------------------------------
    */


    /**
     * Checks whether the product is active or not .
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return ($this->isEnable() && $this->isValid() ? true : false);
    }

    /**
     * Checks whether the product is enable or not .
     *
     * @return bool
     */
    public function isEnable(): bool
    {
        if ($this->enable) {
            return true;
        }

        return false;
    }

    /**
     * Checks whether the product is valid or not .
     *
     * @return bool
     */
    public function isValid(): bool
    {
        if (($this->validSince < Carbon::createFromFormat('Y-m-d H:i:s',
                    Carbon::now())
                    ->timezone('Asia/Tehran') || $this->validSince === null) && ($this->validUntil > Carbon::createFromFormat('Y-m-d H:i:s',
                    Carbon::now())
                    ->timezone('Asia/Tehran') || $this->validUntil === null)) {
            return true;
        }

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

    /*
    |--------------------------------------------------------------------------
    | Other
    |--------------------------------------------------------------------------
    */

    public function getTypeAttribute()
    {

        return [
            'id'   => $this->producttype->id,
            'type' => $this->producttype->name,
            'hint' => $this->producttype->displayName,
        ];
    }

    public function getUrlAttribute($value): string
    {
        return action("Web\ProductController@show", $this);
    }

    public function getApiUrlAttribute($value): array
    {
        return [
            'v1' => action("Api\ProductController@show", $this),
        ];
    }

    public function getGiftAttribute(): ProductCollection
    {
        return $this->getGifts();
    }

    public function getGifts(): ProductCollection
    {
        $key = 'product:getGifts:'.$this->cacheKey();

        return Cache::tags(['product'])
            ->remember($key, config('constants.CACHE_60'), function () {
                return $this->gifts->merge(optional($this->grandParent)->gift ?? collect());
            });
    }

    public function validateProduct()
    {
        if (!$this->enable) {
            return 'محصول مورد نظر غیر فعال است';
        }

        if (isset($this->amount) && $this->amount >= 0) {
            return 'محصول مورد نظر تمام شده است';
        }

        if (isset($this->validSince) && Carbon::now() < $this->validSince) {
            return 'تاریخ شروع سفارش محصول مورد نظر آغاز نشده است';
        }

        if (isset($this->validUntil) && Carbon::now() > $this->validUntil) {
            return 'تاریخ سفارش محصول مورد نظر  به پایان رسیده است';
        }

        return '';
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

    public function shouldBeSearchable()
    {
        return $this->isPublished();
    }

    private function isPublished()
    {
        return $this->isActive();
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();
        $keys  = [
            'basePrice',
            'discount',
            'discount',
            'isFree',
            'amount',
            'image',
            'file',
            'introVideo',
            'enable',
            'order',
            'producttype_id',
            'attributeset_id',
            'redirectUrl',
            'tags',
            'page_view',
            'created_at',
            'updated_at',
            'validSince',
            'validUntil',
            'slogan',
        ];
        foreach ($keys as $key) {
            unset($array[$key]);
        }
        return $array;
    }

    /**
     * @return Collection
     * @throws Exception
     */
    public function getAddItems(): Collection
    {
        // TODO: Implement getAddItems() method.
        throw new Exception('product Advertisable should be impediment');
    }


    /**
     * @return Collection
     */
    public function productFileTypesOrder(): collection
    {
        $defaultProductFileOrders = collect();
        $productFileTypes         = Productfiletype::pluck('name', 'id')
            ->toArray();

        foreach ($productFileTypes as $key => $productFileType) {
            $lastProductFile = $this->validProductfiles($productFileType, 0)
                ->get()
                ->first();
            if (isset($lastProductFile)) {
                $lastOrderNumber = $lastProductFile->order + 1;
                $defaultProductFileOrders->push([
                    'fileTypeId' => $key,
                    'lastOrder'  => $lastOrderNumber,
                ]);
            } else {
                $defaultProductFileOrders->push([
                    'fileTypeId' => $key,
                    'lastOrder'  => 1,
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
     * @param  int  $depth
     *
     * @return bool
     */
    public function hasChildren($depth = 1): bool
    {
        //ToDo: This method only works fine for depth value 1 . For depth values more than 1 it does not return the correct output
        $key = 'product:hasChildren:'.$depth.$this->cacheKey();

        return Cache::tags(['product'])
            ->remember($key, config('constants.CACHE_600'), function () use ($depth) {
                $counter    = 1;
                $myChildren = $this->children->first();
                while (isset($myChildren)) {
                    if ($counter >= $depth) {
                        break;
                    }
                    $myChildren = $myChildren->children->first();
                    $counter++;
                }
                if (!isset($myChildren) || $counter != $depth) {
                    return false;
                } else {
                    return true;
                }
            });
    }

    /**
     * @return string
     */
    public function makeProductLink(): string
    {
        $key = 'product:makeProductLink:'.$this->cacheKey();

        return Cache::tags(['product'])
            ->remember($key, config('constants.CACHE_60'), function () {
                $link        = '';
                $grandParent = $this->grandParent;
                if (isset($grandParent)) {
                    if ($grandParent->enable) {
                        $link = action("Web\ProductController@show", $this->grandParent);
                    }
                } else {
                    if ($this->enable) {
                        $link = action("Web\ProductController@show", $this);
                    }
                }

                return $link;
            });
    }

    /** Makes an array of files with specific type
     *
     * @param  string  $type
     *
     * @return array
     */
    public function makeFileArray($type): array
    {
        $filesArray    = [];
        $productsFiles = $this->validProductfiles($type)
            ->get();
        foreach ($productsFiles as $productfile) {
            $filesArray[] = [
                'file'       => $productfile->file,
                'name'       => $productfile->name,
                'product_id' => $productfile->product_id,
            ];
        }

        return $filesArray;
    }


    /**
     * Obtains product's price (rawCost)
     *
     * @return int|null
     */
    public function obtainPrice(): ?int
    {
        $key = 'product:obtainPrice:'.$this->cacheKey();

        return Cache::tags(['product'])
            ->remember($key, config('constants.CACHE_10'), function () {
                if (!$this->isFree()) {
                    if ($this->isRoot()) {
                        if ($this->producttype_id == config('constants.PRODUCT_TYPE_CONFIGURABLE')) {
                            /** @var Collection $enableChildren */
                            $enableChildren = $this->children->where('enable',
                                1); // It is not query efficient to use scopeEnable
                            if ($enableChildren->count() == 1) {
                                $cost = $enableChildren->first()
                                    ->obtainPrice();
                            } else {
                                $cost = $this->basePrice;
                            }
                        } elseif ($this->producttype_id == config('constants.PRODUCT_TYPE_SELECTABLE'))
                        {
                                $allChildren = $this->getAllChildren()
                                    ->where('pivot.isDefault', 1);
                                if ($allChildren->isNotEmpty()) {
                                    $cost = 0;
                                    foreach ($allChildren as $product) {
                                        /** @var Product $product */
                                        $cost += $product->obtainPrice();
                                    }
                                } else if ($this->basePrice != 0) {
                                        $cost = $this->basePrice;
                                }else{
                                    $cost = null;
                                }

                        } else {
                            $cost = $this->basePrice;
                        }

                    } else {
                        $grandParent            = $this->grandParent;
                        $grandParentProductType = $grandParent->producttype_id;
                        if ($grandParentProductType == config('constants.PRODUCT_TYPE_CONFIGURABLE')) {
                            if ($this->basePrice != 0) {
                                $cost = $this->basePrice;
                            } else {
                                $cost = $grandParent->basePrice;
                            }

                            //ToDo :Commented for the sake of reducing queries . This snippet gives a second approach for calculating children's cost of a configurable product
                            /*$attributevalues = $this->attributevalues->where("attributetype_id", config("constants.ATTRIBUTE_TYPE_MAIN"));
                            foreach ($attributevalues as $attributevalue) {
                                if (isset($attributevalue->pivot->extraCost))
                                    $cost += $attributevalue->pivot->extraCost;
                            }*/
                        }elseif ($grandParentProductType == config('constants.PRODUCT_TYPE_SELECTABLE')) {
                            if ($this->basePrice == 0) {
                                $children = $this->children;
                                $cost     = 0;
                                foreach ($children as $child) {
                                    $cost = $child->basePrice;
                                }
                            } else {
                                $cost = $this->basePrice;
                            }
                        }else{
                            $cost = 0;
                        }
                    }
                }else{
                    $cost = 0;
                }

                return $cost;
            });
    }

    /**
     * Checks whether this product is free or not
     *
     * @return bool
     */
    public function isFree(): bool
    {
        return ($this->isFree) ? true : false;
    }

    public function isRoot(): bool
    {
        return is_null($this->grand_id);
    }

    /**
     * Gets a collection containing all of product children
     *
     * @return Collection
     */
    public function getAllChildren(): Collection
    {
        $key = 'product:makeChildrenArray:'.$this->cacheKey();

        return Cache::tags(['product'])
            ->remember($key, config('constants.CACHE_600'), function () {
                $children = collect();
                if ($this->hasChildren()) {
                    $thisChildren = $this->children;
                    $children     = $children->merge($thisChildren);
                    foreach ($thisChildren as $child) {
                        $children = $children->merge($child->getAllChildren());
                    }
                }

                return $children;
            });
    }

    public function getAllParents(): Collection
    {
        $myProduct = $this;
        $key       = 'product:getAllParents:'.$myProduct->cacheKey();

        return Cache::tags(['product'])
            ->remember($key, config('constants.CACHE_600'), function () use ($myProduct) {
            $parents = collect();
            while ($myProduct->hasParents()) {
                $myparent = $myProduct->parents->first();
                $parents->push($myparent);
                $myProduct = $myparent;
            }

            return $parents;
        });
    }

    /**
     * @return Collection
     */
    public function getProductChain()
    {
        $productChain = collect();
        $parents      = $this->getAllParents();
        $productChain = $productChain->merge($parents);

        $children     = $this->getAllChildren();
        $productChain = $productChain->merge($children);

        return $productChain;
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
     * Obtains discount value base on product parents
     *
     * @return float
     */
    public function getFinalDiscountValue()
    {
        $key = 'product:getFinalDiscountValue:'.$this->cacheKey();

        return Cache::tags(['product'])
            ->remember($key, config('constants.CACHE_10'), function () {
                $discount = 0;
                if (!$this->isRoot()) {
                    $grandParent            = $this->grandParent;
                    $grandParentProductType = $grandParent->producttype_id;
                    if ($grandParentProductType == config('constants.PRODUCT_TYPE_CONFIGURABLE')) {
                        if ($this->discount > 0) {
                            $discount += $this->discount;
                        } else {
                            if ($grandParent->discount > 0) {
                                $discount += $this->parents->first()->discount;
                            }
                        }
                    } else {
                        if ($grandParentProductType == config('constants.PRODUCT_TYPE_SELECTABLE')) {
                            $discount = $this->discount;
                        }
                    }
                } else {
                    $discount = $this->discount;
                }

                return $discount;
            });
    }

    /**
     * Obtains product's discount amount in cash
     *
     * @return int
     */
    public function obtainDiscountAmount(): int
    {
        $key = 'product:obtainDiscountAmount:'.$this->cacheKey();

        return Cache::tags(['product'])
            ->remember($key, config('constants.CACHE_10'), function () {
                $discountAmount = 0;
                if (!$this->isRoot()) {
                    $grandParent            = $this->grandParent;
                    $grandParentProductType = $grandParent->producttype_id;
                    if ($grandParentProductType == config('constants.PRODUCT_TYPE_SELECTABLE')) {
                        if ($this->basePrice == 0) {
                            $children = $this->children;
                            foreach ($children as $child) {
                                $discountAmount += ($child->discount / 100) * $child->basePrice;
                            }
                        }
                    }
                }

                return $discountAmount;
            });
    }

    /**
     * Disables the product
     *
     */
    public function setDisable(): void
    {
        $this->enable = 0;
    }

    /**
     * Enables the product
     *
     */
    public function setEnable(): void
    {
        $this->enable = 1;
    }

    /** edit amount of product
     *
     * @param  int  $value
     */
    public function decreaseProductAmountWithValue(int $value): void
    {
        if (isset($this->amount) && $this->amount > 0) {
            if ($this->amount < $value) {
                $this->amount = 0;
            } else {
                $this->amount -= $value;
            }
            $this->update();
        }
    }

    public function getActiveAttribute()
    {
        if ($this->validSince != null) {
            $now = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())
                ->timezone('Asia/Tehran');
            if (Carbon::parse($this->validSince)
                    ->lte($now) && Carbon::parse($this->validUntil)
                    ->gte($now)) {
                return true;
            } else {
                return false;
            }
        }

        return true;
    }

    public function getSetsAttribute()
    {
        $key = 'product:sets:'.$this->cacheKey();

        return Cache::tags(['product'])
            ->remember($key, config('constants.CACHE_600'), function () {
                /** @var SetCollection $sets */
                $sets = $this->sets()
                    ->wherePivot('deleted_at', '=', null)
                    ->get();
                return $sets;
            });
    }

    /**
     * The products that belong to the set.
     */
    public function sets()
    {
        return $this->belongsToMany('App\Contentset')
            ->using('App\ProductSet')
            ->as('productSet')
            ->withPivot([
                'order',
            ])
            ->withTimestamps()
            ->orderBy('order');
    }

    public function getEnableAttribute($value)
    {
        //ToDo
//        if (hasAuthenticatedUserPermission(config('constants.SHOW_PRODUCT_ACCESS')))
        return $value;
    }

    public function getAttributeSetAttribute()
    {
        $product = $this;
        $key     = 'product:attributeset:'.$product->cacheKey();
        return Cache::tags(['product'])
            ->remember($key, config('constants.CACHE_600'), function () use ($product) {
                //ToDo
//                if (hasAuthenticatedUserPermission(config('constants.SHOW_PRODUCT_ACCESS')))
                return optional($product->attributeset()
                    ->first())->setVisible([
                    'name',
                    'description',
                    'order',
                ]);

            });
    }

    public function getJalaliValidSinceAttribute()
    {
        $product = $this;
        $key     = 'product:jalaliValidSince:'.$product->cacheKey();
        return Cache::tags(['product'])
            ->remember($key, config('constants.CACHE_600'), function () use ($product) {
                if (hasAuthenticatedUserPermission(config('constants.SHOW_PRODUCT_ACCESS'))) {
                    return $this->convertDate($product->validSince, 'toJalali');
                }
                return null;
            });
    }

    public function getJalaliValidUntilAttribute()
    {
        $product = $this;
        $key     = 'product:jalaliValidUntil:'.$product->cacheKey();
        return Cache::tags(['product'])
            ->remember($key, config('constants.CACHE_600'), function () use ($product) {
                if (hasAuthenticatedUserPermission(config('constants.SHOW_PRODUCT_ACCESS'))) {
                    return $this->convertDate($product->validUntil, 'toJalali');
                }
                return null;
            });
    }

    public function getJalaliCreatedAtAttribute()
    {
        $product = $this;
        $key     = 'product:jalaliCreatedAt:'.$product->cacheKey();
        return Cache::tags(['product'])
            ->remember($key, config('constants.CACHE_600'), function () use ($product) {
                if (hasAuthenticatedUserPermission(config('constants.SHOW_PRODUCT_ACCESS'))) {
                    return $this->convertDate($product->created_at, 'toJalali');
                }
                return null;
            });
    }

    public function getJalaliUpdatedAtAttribute()
    {
        $product = $this;
        $key     = 'product:jalaliUpdatedAt:'.$product->cacheKey();
        return Cache::tags(['product'])
            ->remember($key, config('constants.CACHE_600'), function () use ($product) {
                return $this->convertDate($product->updated_at, 'toJalali');
            });
    }

    public function getBonPlusAttribute()
    {
        if (hasAuthenticatedUserPermission(config('constants.SHOW_PRODUCT_ACCESS'))) {
            return $this->calculateBonPlus(Bon::ALAA_BON);
        }

        return null;
    }

    public function getBonDiscountAttribute()
    {
        if (hasAuthenticatedUserPermission(config('constants.SHOW_PRODUCT_ACCESS'))) {
            return $this->obtainBonDiscount(config('constants.BON1'));
        }

        return null;
    }

    public function getEditLinkAttribute()
    {
        if (hasAuthenticatedUserPermission(config('constants.EDIT_PRODUCT_ACCESS'))) {
            return action('Web\ProductController@edit', $this->id);
        }

        return null;

    }

    public function getRemoveLinkAttribute()
    {
        if (hasAuthenticatedUserPermission(config('constants.REMOVE_PRODUCT_ACCESS'))) {
            return action('Web\ProductController@destroy', $this->id);
        }

        return null;
    }

    public function getChildrenAttribute(){
        $product = $this;
        $key     = 'product:children:'.$product->cacheKey();
        return Cache::tags(['product'])
            ->remember($key, config('constants.CACHE_600'), function () use ($product) {
                return $this->children()->get();
            });

    }

    public function getIntroVideoAttribute(){
        $intro = $this->intro_videos;
        if(is_null($intro))
            return null;

        $intro = json_decode($intro);

        if(!isset($intro[0]) || !isset($intro[0]->video))
            return null;

        $videos = $intro[0]->video;

        if( !isset($videos[0]) || !isset($videos[0]->url))
            return null;

        return $videos[0]->url;
    }

    public function getIntroVideoThumbnailAttribute(){
        $intro = $this->intro_videos;
        if(is_null($intro))
            return null;

        $intro = json_decode($intro);
        if(!isset($intro[0]) || !isset($intro[0]->thumbnail))
            return null;

        $thumbnail = $intro[0]->thumbnail;

        if(!isset($thumbnail->url))
            return null;

        return $thumbnail->url;
    }
}
