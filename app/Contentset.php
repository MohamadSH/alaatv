<?php

namespace App;

use App\Classes\Taggable;
use Laravel\Scout\Searchable;
use App\Traits\favorableTraits;
use App\Collection\SetCollection;
use App\Traits\Set\TaggableSetTrait;
use App\Collection\ProductCollection;
use Illuminate\Support\Facades\Cache;
use App\Collection\ContentCollection;

/**
 * App\Contentset
 *
 * @property int                                                   $id
 * @property string|null                                           $name        نام
 * @property string|null                                           $description توضیح
 * @property string|null                                           $photo       عکس پوستر
 * @property string|null                                           $tags        تگ ها
 * @property int                                                   $enable      فعال/غیرفعال
 * @property int                                                   $display     نمایش/عدم نمایش
 * @property \Carbon\Carbon|null                                   $created_at
 * @property \Carbon\Carbon|null                                   $updated_at
 * @property \Carbon\Carbon|null                                   $deleted_at
 * @property-read \App\Collection\ContentCollection|\App\Content[] $contents
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Contentset onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contentset whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contentset whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contentset whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contentset whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contentset whereEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contentset whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contentset whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contentset wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contentset whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contentset whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contentset withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Contentset withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contentset active()
 * @property-read \App\Collection\UserCollection|\App\User[]       $favoriteBy
 * @property string|null                                           $small_name
 * @property-read mixed                                            $short_name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contentset whereSmallName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contentset newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contentset newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contentset query()
 * @property-read mixed                                            $author
 * @property-read mixed                                            $url
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                            $api_url
 * @property-read mixed                                            $content_url
 * @property-read mixed                                            $cache_cooldown_seconds
 * @property-read \App\Collection\ContentCollection|\App\Content[] $contents2
 * @property-read \App\Collection\ProductCollection|\App\Product[] $products
 */
class Contentset extends BaseModel implements Taggable
{
    use favorableTraits;
    use Searchable;
    use TaggableSetTrait;
    
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'small_name',
        'description',
        'photo',
        'enable',
        'display',
    ];
    
    protected $withCount = [
        'contents',
    ];
    
    protected $appends = [
        'url',
        'apiUrl',
        'shortName',
        'author',
        'contentUrl',
    ];
    
    protected $hidden = [
        'deleted_at',
        'small_name',
        'pivot',
        'enable',
        'display',
        'productSet',
    ];
    
    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     *
     * @return SetCollection
     */
    public function newCollection(array $models = [])
    {
        return new SetCollection($models);
    }
    
    
    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'contents_index';
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
        
        $unSetArrayItems = [
            'tags',
            'photo',
            'url',
            'apiUrl',
            'shortName',
            'author',
            'contentUrl',
            'deleted_at',
            'small_name',
            'pivot',
            'enable',
            'display',
            'updated_at',
            'created_at',
        ];
        foreach ($unSetArrayItems as $item) {
            unset($array[$item]);
        }
        return $array;
    }
    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */
    
    /**
     * Scope a query to only include active Contentsets.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('enable', 1);
    }
    
    public function scopeDisplay($query)
    {
        return $query->where('display', 1);
    }
    
    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */
    
    public function getContentUrlAttribute($value)
    {
        return action('Web\ContentController@index', [
            'set'         => $this->id,
            'contentOnly' => true,
            'free'        => [0, 1],
        ]);
    }
    
    public function getProducts($onlyActiveProduct = true): ProductCollection
    {
        $key = 'products-of-set:'.$this->cacheKey().'onlyActiveProduct-'.$onlyActiveProduct;
        return Cache::tags(['set', 'product'])
            ->remember($key, config('constants.CACHE_60'), function () use ($onlyActiveProduct) {
                return self::getProductOfSet($onlyActiveProduct, $this);
            });
    }
    
    /**
     * @param  bool        $onlyActiveProduct
     * @param  Contentset  $set
     *
     * @return ProductCollection
     */
    public static function getProductOfSet(bool $onlyActiveProduct, Contentset $set): ProductCollection
    {
        return ($onlyActiveProduct ? $set->products()
            ->active()
            ->get() : $set->products()
            ->get()) ?: new
        ProductCollection();
    }
    
    
    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->using(ProductSet::class)
            ->as('productSet')
            ->withPivot([
                'order',
            ])
            ->withTimestamps()
            ->orderBy('order');
    }
    
    /*
    |--------------------------------------------------------------------------
    |
    |--------------------------------------------------------------------------
    */
    
    //Old way ( before migrate)
    
    public function getShortNameAttribute($value)
    {
        return $this->small_name;
    }
    
    
    //new way ( after migrate )
    
    public function getTagsAttribute($value)
    {
        return json_decode($value);
    }
    
    /**
     * Set the set's tag.
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
                'bucket' => 'contentset',
                'tags'   => $value,
            ], JSON_UNESCAPED_UNICODE);
        }
        
        $this->attributes['tags'] = $tags;
    }
    
    public function getUrlAttribute($value): string
    {
        $content   = $this->getLastActiveContent();
        $contentId = !is_null($content) ? $content->id : null;
    
        return isset($contentId) ? action("Web\ContentController@show", $contentId) : '';
    }
    
    public function getLastActiveContent(): Content
    {
        $key = 'ContentSet:getLastActiveContent'.$this->cacheKey();
        
        return Cache::tags('set')
            ->remember($key, config('constants.CACHE_300'), function () {
                
                $r = $this->getActiveContents();
        
                return $r->sortByDesc('order')
                    ->first() ?: new Content();
            });
    }

    public function getLastContent(): Content
    {
        $key = 'ContentSet:getLastContent'.$this->cacheKey();

        return Cache::tags('set')
            ->remember($key, config('constants.CACHE_300'), function () {

                $r = $this->getContents();
        
                return $r->sortByDesc('order')
                    ->first() ?: new Content();
            });
    }

    public function getActiveContents(): ContentCollection
    {
        $key = 'ContentSet:getActiveContents'.$this->cacheKey();
        
        return Cache::tags('set')
            ->remember($key, config('constants.CACHE_300'), function () {
                
                $oldContentCollection = $this->oldContents()
                    ->active()
                    ->get() ?: new ContentCollection();
                $newContentCollection = $this->contents()
                    ->active()
                    ->get() ?: new ContentCollection();
                return $oldContentCollection->merge($newContentCollection);
                
            });
    }

    public function getContents(): ContentCollection
    {
        $key = 'ContentSet:getContents'.$this->cacheKey();

        return Cache::tags('set')
            ->remember($key, config('constants.CACHE_300'), function () {

                $oldContentCollection = $this->oldContents()
                    ->get() ?: new ContentCollection();
                $newContentCollection = $this->contents()
                    ->get() ?: new ContentCollection();
                return $oldContentCollection->merge($newContentCollection);

            });
    }

    public function oldContents()
    {
        return $this->belongsToMany(Content::class, 'contentset_educationalcontent', 'contentset_id', 'edc_id')
            ->withPivot('order', 'isDefault');
    }
    
    public function contents()
    {
        return $this->hasMany(Content::class);
    }
    
    public function getApiUrlAttribute($value): array
    {
        return [
            'v1' => action("Api\SetController@show", $this),
        ];
    }
    
    /**
     * @param $value
     *
     * @return User
     */
    public function getAuthorAttribute($value): User
    {
        $content = $this->getLastActiveContent();
        
        $author = $content->author;
        
        return $author->setVisible([
            'id',
            'firstName',
            'lastName',
            'photo',
            'full_name',
        ]);
    }
    
    
    public function isActive()
    {
        return $this->isEnable();
    }
    
    public function isEnable(): bool
    {
        if ($this->enable) {
            return true;
        }
        
        return false;
    }
}
