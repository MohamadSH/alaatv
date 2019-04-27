<?php

namespace App;

use App\Classes\Taggable;
use App\Collection\ContentCollection;
use App\Collection\ProductCollection;
use App\Collection\SetCollection;
use App\Traits\favorableTraits;
use Illuminate\Support\Facades\Cache;

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
 */
class Contentset extends BaseModel implements Taggable
{
    use favorableTraits;
    
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'tags',
        'photo',
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
        ]);
    }
    
    public function getProducts($onlyActiveProduct = true): ProductCollection
    {
        $key = 'products-of-set:'.$this->id.'onlyActiveProduct-'.$onlyActiveProduct;
        return Cache::tags(['set', 'product'])
            ->remember($key, config('constants.CACHE_60'), function () use ($onlyActiveProduct) {
                return ($onlyActiveProduct ? $this->products()
                    ->active()
                    ->get() : $this->products()
                    ->get()) ?: new ProductCollection();
            });
        
    }
    
    public function products()
    {
        return $this->belongsToMany('App\Product')
            ->using('App\ProductSet')
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
    public function setTagsAttribute(array $value)
    {
        $tags = null;
        if (!empty($value)) {
            $tags = json_encode([
                "bucket" => "contentset",
                "tags"   => $value,
            ], JSON_UNESCAPED_UNICODE);
        }
        
        $this->attributes['tags'] = $tags;
    }
    
    public function getUrlAttribute($value): string
    {
//        return action("Web\ContentsetController@show",$this);
        $content   = $this->getLastContent();
        $contentId = !is_null($content) ? $content->id : null;
        
        return isset($contentId) ? action("Web\ContentController@show", $contentId) : "";
    }
    
    public function getLastContent(): Content
    {
        $key = "ContentSet:getLastContent".$this->cacheKey();
        
        return Cache::tags('set')
            ->remember($key, config("constants.CACHE_300"), function () {
                
                $r = $this->getContents();
                
                return $r->sortByDesc("order")
                    ->first() ?: new Content();
            });
    }
    
    public function getContents(): ContentCollection
    {
        $key = "ContentSet:getContents".$this->cacheKey();
        
        return Cache::tags('set')
            ->remember($key, config("constants.CACHE_300"), function () {
                
                $oldContentCollection = $this->contents()
                    ->active()
                    ->get() ?: new ContentCollection();
                $newContentCollection = $this->contents2()
                    ->active()
                    ->get() ?: new ContentCollection();
                return $oldContentCollection->merge($newContentCollection);
                
            });
    }
    
    public function contents()
    {
        return $this->belongsToMany("\App\Content", "contentset_educationalcontent", "contentset_id", "edc_id")
            ->withPivot("order", "isDefault");
    }
    
    public function contents2()
    {
        return $this->hasMany('\App\Content');
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
        $content = $this->getLastContent();
        
        $author = $content->author;
        
        return $author->setVisible([
            'id',
            'firstName',
            'lastName',
            'photo',
            'full_name',
        ]);
    }
    
    public function retrievingTags()
    {
        /**
         *      Retrieving Tags
         */
        $response = $this->sendRequest(config("constants.TAG_API_URL")."id/contentset/".$this->id, "GET");
        
        if ($response["statusCode"] == 200) {
            $result = json_decode($response["result"]);
            $tags   = $result->data->tags;
        }
        else {
            $tags = [];
        }
        
        return $tags;
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
        return !is_null($this->created_at) ? $this->created_at->timestamp : null;
    }
    
    public function isTaggableActive(): bool
    {
        if ($this->isActive() && isset($this->tags) && !empty($this->tags->tags)) {
            return true;
        }
        
        return false;
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
