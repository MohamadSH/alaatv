<?php

namespace App;

use App\Collection\BlockCollection;
use App\Collection\ContentCollection;
use App\Collection\ProductCollection;
use App\Collection\SetCollection;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

/**
 * App\Block
 *
 * @property int                              $id
 * @property string|null                      $title
 * @property string|null                      $tags
 * @property int                              $order
 * @property int                              $enable
 * @property Carbon|null                      $created_at
 * @property Carbon|null $updated_at
 * @property-read ContentCollection|Content[] $contents
 * @property-read ProductCollection|Product[] $products
 * @property-read SetCollection|Contentset[]  $sets
 * @method static Builder|Block active()
 * @method static Builder|Block enable()
 * @method static Builder|Block whereCreatedAt($value)
 * @method static Builder|Block whereEnable($value)
 * @method static Builder|Block whereId($value)
 * @method static Builder|Block whereOrder($value)
 * @method static Builder|Block whereTags($value)
 * @method static Builder|Block whereTitle($value)
 * @method static Builder|Block whereUpdatedAt($value)
 * @mixin Eloquent
 * @property string|null                      $class
 * @method static Builder|Block whereClass($value)
 * @method static Builder|Block newModelQuery()
 * @method static Builder|Block newQuery()
 * @method static Builder|Block query()
 * @property int                              $type
 * @property Carbon|null                      $deleted_at
 * @property-read Collection|Slideshow[]      $banners
 * @property-read string                      $url
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|Block main()
 * @method static Builder|Block shop()
 * @method static Builder|Block whereDeletedAt($value)
 * @method static Builder|Block whereType($value)
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property mixed                            $offer
 * @property-read mixed                       $cache_cooldown_seconds
 * @property mixed                            customUrl
 * @property-read int|null                    $banners_count
 * @property-read int|null                    $contents_count
 * @property-read mixed                       $edit_link
 * @property-read mixed                       $remove_link
 * @property-read int|null                    $products_count
 * @property-read int|null                    $sets_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Block onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Block whereCustomUrl($value)
 * @method static \Illuminate\Database\Query\Builder|Block withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Block withoutTrashed()
 */
class Block extends BaseModel
{
    public static $BLOCK_TYPE_MAIN = 1;

    public static $BLOCK_TYPE_SHOP = 2;

    public static $BLOCK_TYPE_OFFER = 3;

    public static $BLOCK_TYPE_APP_HOME_BANNER = 4;

    public static $BLOCK_TYPE_APP_SHOP_BANNER = 5;

    protected static $actionLookupTable = [
        '1' => 'Web\ContentController@index',
        '2' => 'Web\ProductController@index',
        '3' => null,
    ];

    protected static $actionLookupTableV2 = [
        '1' => 'Api\SearchController@index',
        '2' => 'Web\ProductController@index',
        '3' => null,
    ];

    protected $isOfferBlock = false;

    protected $cascadeDeletes = [
        'blockables',
    ];

    protected $fillable = [
        'title',
        'tags',
        'class',
        'order',
        'enable',
        'type',
        'customUrl',
    ];

    protected $appends = [
        'url',
        'offer',
    ];

    protected $hidden = [
        'enable',
        'tags',
        'created_at',
        'class',
        'deleted_at',
        //        'type',
    ];
    
    public static function getHomeBannerBlock()
    {
        return self::getDummyBlock(false, '', null, null, null, Slideshow::getMainBanner());
    }

   public static function getShopBlocks(): ?BlockCollection
    {
        $blocks = Cache::tags(['block', 'shop'])
            ->remember('block:getShopBlocks', config('constants.CACHE_600'), function () {
                $offerBlock = self::getOfferBlock();
                $blocks     = self::shop()
                    ->enable()
                    ->where('id', '<>', 115)
                    ->orderBy('order')
                    ->get()
                    ->loadMissing([
                        'contents',
                        'sets',
                        'products',
                        'banners',
                    ]);

                return $blocks->prepend($offerBlock);
            });

        return $blocks;
    }

    /**
     * @return Block
     */
    protected static function getOfferBlock(): Block
    {
        return self::getDummyBlock(true, 'الماس و جزوات', Product::getProductsHaveBestOffer());
    }

    public static function getDummyBlock(
        bool $offer,
        string $title,
        ProductCollection $products = null,
        SetCollection $sets = null,
        ContentCollection $contents = null,
        \Illuminate\Support\Collection $banners = null
    )
    {
        //TODO:// add Cache Layer!
        $block        = new Block;
        $block->id    = 0;
        $block->offer = $offer;
//        $block->type  = 3;
        $block->order = 0;
        $block->title = $title;

        return $block->addProducts($products)
            ->addContents($contents)
            ->addSets($sets)
            ->addBanners($banners);
    }

    protected function addSets($sets)
    {
        if ($sets != null) {
            foreach ($sets as $set) {
                $this->sets->add($set);
            }
        }

        return $this;
    }
    
    protected function addBanners($banners)
    {
        if ($banners != null) {
            foreach ($banners as $banner) {
                $this->banners->add($banner);
            }
        }
        
        return $this;
    }
    
    protected function addContents($contents)
    {
        if ($contents != null) {
            foreach ($contents as $content) {
                $this->contents->add($content);
            }
        }

        return $this;
    }

    protected function addProducts($products)
    {
        if ($products != null) {
            foreach ($products as $product) {
                $this->products->add($product);
            }
        }

        return $this;
    }

    /**
     * For API V1
     *
     * @return BlockCollection|null
     */
    public static function getShopBlocksForApp(): ?BlockCollection
    {
        return Cache::tags(['block', 'shop'])
            ->remember('block:getShopBlocksForApp', config('constants.CACHE_600'), function () {
                $offerBlock = self::getOfferBlock();
                $blocks     = self::shop()
                    ->enable()
                    ->where('id', '<>', 113)
                    ->orderBy('order')
                    ->get()
                    ->loadMissing([
                        'contents',
                        'sets',
                        'products',
                        'banners',
                    ]);

                return $blocks->prepend($offerBlock);
            });
    }

    /**
     * For API V2
     *
     * @return mixed
     */
    public static function getShopBlocksForAppV2()
    {
        return Cache::tags(['block', 'shop'])
            ->remember('block:getShopBlocksForAppV2', config('constants.CACHE_600'), function () {
                return self::appShop()
                    ->enable()
                    ->where('id', '<>', 113)
                    ->orderBy('order')
                    ->paginate(5);
            });
    }

    public static function getMainBlocksForAppV2(): ?LengthAwarePaginator
    {
        return Cache::tags(['block', 'home'])
            ->remember('block:getMainBlocksForApp', config('constants.CACHE_600'), function () {
                return self::appMain()
                    ->enable()
                    ->orderBy('order')
                    ->paginate(5);
            });
    }

    public static function getMainBlocks(): ?BlockCollection
    {
        $blocks = Cache::tags(['block', 'home'])
            ->remember('block:getMainBlocks', config('constants.CACHE_600'), function () {
                $blocks = self::main()
                    ->enable()
                    ->orderBy('order')
                    ->get()
                    ->loadMissing([
                        'notRedirectedContents',
                        'notRedirectedSets',
                        'products',
                        'banners',
                    ]);

                return $blocks;
            });
        return $blocks;
    }

    public static function getContentBlocks(): ?BlockCollection
    {
        $blocks = Cache::tags(['block', 'content'])
            ->remember('block:getContentBlocks', config('constants.CACHE_600'), function () {
                $blocks = self::findMany([115])
                    ->loadMissing([
                        'contents',
                        'sets',
                        'products',
                        'banners',
                    ]);

                return $blocks;
            });
        return $blocks;
    }

    /**
     * Scope a query to only blocks for shop.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeShop($query)
    {
        return $query->where('type', 2);
    }

    /**
     * Scope a query to only blocks for shop.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeAppShop($query)
    {
        return $query->where('type', 5)->orWhere('type', 2);
    }

    /**
     * Scope a query to only blocks for HomePage.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeMain($query)
    {
        return $query->where('type', 1);
    }

    /**
     * Scope a query to only blocks for HomePage.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeAppMain($query)
    {
        return $query->where('type', 4)->orWhere('type', 1);
    }

    public function getOfferAttribute($value)
    {
        return $this->isOfferBlock;
    }

    public function setOfferAttribute($value)
    {
        return $this->isOfferBlock = (boolean)$value;
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function getUrlAttribute($value): ?string
    {
        if (isset($this->customUrl))
            return $this->customUrl;
        return isset(self::$actionLookupTable[$this->type]) ? $this->makeUrl(self::$actionLookupTable[$this->type],
            $this->tags) : null;
    }

    public function getUrlV2Attribute($value): ?string
    {
        if (isset($this->customUrl))
            return $this->customUrl;
        return isset(self::$actionLookupTableV2[$this->type]) ? $this->makeUrl(self::$actionLookupTableV2[$this->type],
            $this->tags) : null;
    }

    private function makeUrl($action, $input = null)
    {
        if ($input) {
            return urldecode(action($action, ['tags' => $input]));
        } else {
            return urldecode(action($action));
        }
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param array $models
     *
     * @return BlockCollection
     */
    public function newCollection(array $models = [])
    {
        return new BlockCollection($models);
    }

    public function getTagsAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * Scope a query to only include enable Blocks.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeEnable($query)
    {
        return $query->where('enable', 1);
    }

    /**
     * Scope a query to only include active Contents.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeActive($query)
    {
        return $query->enable();
    }

    public function notRedirectedContents()
    {
        return $this->contents()->active()->notRedirected();
    }

    public function contents()
    {
        return $this->morphedByMany(Content::class, 'blockable')
            ->withTimestamps()
            ->withPivot(['order'])
            ->orderBy('blockables.order');
    }

    public function notRedirectedSets()
    {
        return $this->sets()->active()->notRedirected();
    }

    public function sets()
    {
        return $this->morphedByMany(Contentset::class, 'blockable')
            ->withTimestamps()
            ->withPivot(['order'])
            ->orderBy('blockables.order');
    }

    public function banners()
    {
        return $this->morphedByMany(Slideshow::class, 'blockable')
            ->withTimestamps()
            ->withPivot(['order'])
            ->orderBy('blockables.order');

    }

    public function getEditLinkAttribute()
    {
//        if (hasAuthenticatedUserPermission(config('constants.EDIT_BLOCK_ACCESS')))
        return action('Web\BlockController@edit', $this->id);

        return null;
    }

    public function getRemoveLinkAttribute()
    {
//        if (hasAuthenticatedUserPermission(config('constants.REMOVE_BLOCK_ACCESS')))
        return action('Web\BlockController@destroy', $this->id);

        return null;
    }

    public function getActiveContent(): ContentCollection
    {
        return Cache::tags(['block', 'block_' . $this->id, 'block_' . $this->id . '_activeContents'])->remember('block:activeContent:' . $this->cacheKey(), config('constants.CACHE_60'), function () {
            return $this->contents()
                ->active()
                ->get()->sortBy('pivot.order');
        });
    }

    public function getActiveSets(): SetCollection
    {
        return Cache::tags(['block', 'block_' . $this->id, 'block_' . $this->id . '_activeSets'])->remember('block:activeSets:' . $this->cacheKey(), config('constants.CACHE_60'), function () {
            return $this->sets()
                ->active()
                ->get()->sortBy('pivot.order');
        });
    }

    public function getActiveProducts(): ProductCollection
    {
        return Cache::tags(['block', 'block_' . $this->id, 'block_' . $this->id . '_activeProducts'])->remember('block:activeProducts:' . $this->cacheKey(), config('constants.CACHE_60'), function () {
            return $this->products()
                ->active()
                ->get()->sortBy('pivot.order');
        });
    }

    public function products()
    {
        return $this->morphedByMany(Product::class, 'blockable')
            ->withTimestamps()
            ->withPivot(['order'])
            ->orderBy('blockables.order');

    }
}
