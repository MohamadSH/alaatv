<?php

namespace App;

use App\Collection\SetCollection;
use App\Collection\BlockCollection;
use App\Collection\ProductCollection;
use App\Collection\ContentCollection;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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
 * @property Carbon|null                      $updated_at
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
 * @property string|null                                           $class
 * @method static Builder|Block whereClass($value)
 * @method static Builder|Block newModelQuery()
 * @method static Builder|Block newQuery()
 * @method static Builder|Block query()
 * @property int                                                       $type
 * @property Carbon|null                           $deleted_at
 * @property-read Collection|Slideshow[] $banners
 * @property-read string                                               $url
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|Block main()
 * @method static Builder|Block shop()
 * @method static Builder|Block whereDeletedAt($value)
 * @method static Builder|Block whereType($value)
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property mixed                                                     $offer
 * @property-read mixed                                                $cache_cooldown_seconds
 */
class Block extends BaseModel
{
    public static $BLOCK_TYPE_MAIN = 1;
    
    public static $BLOCK_TYPE_SHOP = 2;
    
    public static $BLOCK_TYPE_OFFER = 3;
    
    protected static $actionLookupTable = [
        '1' => 'Web\ContentController@index',
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
        'editLink',
        'removeLink',
    ];
    
    protected $hidden = [
        'enable',
        'tags',
        'created_at',
        'class',
        'deleted_at',
        'type',
    ];
    
    public static function getShopBlocks(): ?BlockCollection
    {
        $blocks = Cache::tags('block')
            ->remember('getShopBlocks', config('constants.CACHE_600'), function () {
                $offerBlock = self::getOfferBlock();
                $blocks     = self::shop()
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
        ContentCollection $contents = null
    )
    {
        //TODO:// add Cache Layer!
        $block        = new Block;
        $block->id    = 0;
        $block->offer = $offer;
        $block->type  = 3;
        $block->order = 0;
        $block->title = $title;
        
        return $block->addProducts($products)
            ->addContents($contents)
            ->addSets($sets);
    }
    
    protected function addSets($sets)
    {
        if ($sets != null) {
            foreach ($sets as $set) {
                $this->contents->add($set);
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
    
    public static function getMainBlocks(): ?BlockCollection
    {
        $blocks = Cache::tags('block')
            ->remember('getMainBlocks', config('constants.CACHE_600'), function () {
                $blocks = Block::main()
                    ->orderBy('order')
                    ->get()
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
     * @param  Builder  $query
     *
     * @return Builder
     */
    public function scopeShop($query)
    {
        return $query->where('type', '=', 2);
    }
    
    /**
     * Scope a query to only blocks for HomePage.
     *
     * @param  Builder  $query
     *
     * @return Builder
     */
    public function scopeMain($query)
    {
        return $query->where('type', '=', 1);
    }
    
    public function getOfferAttribute($value)
    {
        return $this->isOfferBlock;
    }
    
    public function setOfferAttribute($value)
    {
        return $this->isOfferBlock = (boolean) $value;
    }
    
    /**
     * @param $value
     *
     * @return string
     */
    public function getUrlAttribute($value): ?string
    {
        if(isset($this->customUrl))
            return $this->customUrl;
        return isset(self::$actionLookupTable[$this->type]) ? $this->makeUrl(self::$actionLookupTable[$this->type],
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
     * @param  array  $models
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
     * @param  Builder  $query
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
     * @param  Builder  $query
     *
     * @return Builder
     */
    public function scopeActive($query)
    {
        return $query->enable();
    }
    
    public function contents()
    {
        return $this->morphedByMany('App\Content', 'blockable')
            ->withTimestamps()
            ->withPivot(['order'])
            ->orderBy('blockables.order');
    }
    
    public function sets()
    {
        return $this->morphedByMany('App\Contentset', 'blockable')
            ->withTimestamps()
            ->withPivot(['order'])
            ->orderBy('blockables.order');
    }
    
    public function products()
    {
        return $this->morphedByMany('App\Product', 'blockable')
            ->withTimestamps()
            ->withPivot(['order'])
            ->orderBy('blockables.order');

    }
    
    public function banners()
    {
        return $this->morphedByMany('App\Slideshow', 'blockable')
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
//            return action('Web\BlockController@destroy', $this->id);
        
        return null;
    }
}
