<?php

namespace App;

use App\Collection\SetCollection;
use App\Collection\BlockCollection;
use App\Collection\ProductCollection;
use App\Collection\ContentCollection;
use Illuminate\Support\Facades\Cache;

/**
 * App\Block
 *
 * @property int                             $id
 * @property string|null                     $title
 * @property string|null                     $tags
 * @property int                             $order
 * @property int                             $enable
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null                                $updated_at
 * @property-read \App\Collection\ContentCollection|\App\Content[]          $contents
 * @property-read \App\Collection\ProductCollection|\App\Product[]          $products
 * @property-read \App\Collection\SetCollection|\App\Contentset[]           $sets
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block enable()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null                                                    $class
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block query()
 * @property int                                                            $type
 * @property \Illuminate\Support\Carbon|null                                $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Slideshow[] $banners
 * @property-read string                                                    $url
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block main()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block shop()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property mixed                                                          $offer
 * @property-read mixed                                                     $cache_cooldown_seconds
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
     * @return \App\Block
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
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeShop($query)
    {
        return $query->where('type', '=', 2);
    }
    
    /**
     * Scope a query to only blocks for HomePage.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
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
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEnable($query)
    {
        return $query->where('enable', 1);
    }
    
    /**
     * Scope a query to only include active Contents.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
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
}
