<?php

namespace App;

use App\Classes\FavorableInterface;
use App\Classes\SEO\SeoInterface;
use App\Classes\SEO\SeoMetaTagsGenerator;
use App\Classes\Taggable;
use App\Collection\ContentCollection;
use App\Collection\ProductCollection;
use App\Collection\SetCollection;
use App\Collection\UserCollection;
use App\Http\Controllers\Web\SetController;
use App\Traits\favorableTraits;
use App\Traits\Set\TaggableSetTrait;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Laravel\Scout\Searchable;
use Stevebauman\Purify\Facades\Purify;

/**
 * App\Contentset
 *
 * @property int                              $id
 * @property string|null                      $name        نام
 * @property string|null                      $description توضیح
 * @property string|null                      $photo       عکس پوستر
 * @property string|null                      $tags        تگ ها
 * @property int                              $enable      فعال/غیرفعال
 * @property int                              $display     نمایش/عدم نمایش
 * @property Carbon|null                      $created_at
 * @property Carbon|null                      $updated_at
 * @property Carbon|null                      $deleted_at
 * @property-read ContentCollection|Content[] $contents
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Contentset onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Contentset whereCreatedAt($value)
 * @method static Builder|Contentset whereDeletedAt($value)
 * @method static Builder|Contentset whereDescription($value)
 * @method static Builder|Contentset whereDisplay($value)
 * @method static Builder|Contentset whereEnable($value)
 * @method static Builder|Contentset whereId($value)
 * @method static Builder|Contentset whereName($value)
 * @method static Builder|Contentset wherePhoto($value)
 * @method static Builder|Contentset whereTags($value)
 * @method static Builder|Contentset whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Contentset withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Contentset withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Contentset active()
 * @property-read UserCollection|User[]       $favoriteBy
 * @property string|null                      $small_name
 * @property-read mixed                       $short_name
 * @method static Builder|Contentset whereSmallName($value)
 * @method static Builder|Contentset newModelQuery()
 * @method static Builder|Contentset newQuery()
 * @method static Builder|Contentset query()
 * @property-read mixed                       $author
 * @property-read mixed                       $url
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                       $api_url
 * @property-read mixed                       $content_url
 * @property-read mixed                       $cache_cooldown_seconds
 * @property-read ProductCollection|Product[] $products
 * @property-read int|null                    $contents_count
 * @property-read int|null                    $favorite_by_count
 * @property-read mixed                       $edit_link
 * @property-read mixed                       $remove_link
 * @property-read ContentCollection|Content[] $oldContents
 * @property-read int|null                    $old_contents_count
 * @property-read int|null                    $products_count
 * @property string                           redirectUrl
 * @property ContentCollection                activeContents
 * @property string                           shortName
 * @property Collection                       sources
 * @method static Builder|Contentset display()
 */
class Contentset extends BaseModel implements Taggable, SeoInterface, FavorableInterface
{
    use favorableTraits;
    use Searchable;
    use TaggableSetTrait;

    protected static $purifyNullConfig = ['HTML.Allowed' => ''];
    /**
     * @var array
     */
    protected $fillable = [
        'redirectUrl',
        'name',
        'small_name',
        'description',
        'photo',
        'enable',
        'display',
    ];
    protected $withCount = [
        'contents',
        'activeContents',
    ];
    protected $appends = [
        'url',
        'apiUrl',
        'shortName',
        'author',
        'contentUrl',
        'setUrl',
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
     * @param array $models
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

    public function isActive()
    {
        return $this->isEnable();
    }
    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function isEnable(): bool
    {
        if ($this->enable) {
            return true;
        }

        return false;
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

    /**
     * Scope a query to only include active Contentsets.
     *
     * @param Builder $query
     *
     * @return Builder
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

    public function scopeRedirected($query)
    {
        return $query->whereNotNull('redirectUrl');
    }

    public function scopeNotRedirected($query)
    {
        return $query->whereNull('redirectUrl');
    }

    public function getContentUrlAttribute($value)
    {
        return action('Web\ContentController@index', [
            'set'         => $this->id,
            'contentOnly' => true,
            'free'        => [0, 1],
        ]);
    }

    public function getActiveContentsBySectionAttribute()
    {
        return $this->getActiveContents2()->groupBy('section.name');
    }

    public function getActiveContents2(int $type = null)
    {
        $key = 'set:getActiveContents2:type_' . $type . ':' . $this->cacheKey();
        return Cache::tags(['set', 'activeContent', 'set_' . $this->id, 'set_' . $this->id . '_contents', 'set_' . $this->id . '_activeContents'])
            ->remember($key, config('constants.CACHE_300'), function () use ($type) {
                $contents = $this->activeContents();

                if (isset($type)) {
                    $contents->type($type);
                }

                return $contents->get()
                    ->sortBy('order');
            });
    }

    /**
     * Get all of the tags for the post.
     */
    public function sources()
    {
        return $this->morphToMany(Source::Class, 'sourceable')->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    |
    |--------------------------------------------------------------------------
    */

    //Old way ( before migrate)

    public function activeContents()
    {
        return $this->contents()->with('section')->active();
    }


    //new way ( after migrate )

    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    public function getProducts($onlyActiveProduct = true): ProductCollection
    {
        $key = 'set:getProducts:onlyActive_' . ($onlyActiveProduct) ? '1' : '0' . ':' . $this->cacheKey();
        return Cache::tags(['set', 'product', 'set_' . $this->id, 'set_' . $this->id . '_products'])
            ->remember($key, config('constants.CACHE_60'), function () use ($onlyActiveProduct) {
                return self::getProductOfSet($onlyActiveProduct, $this);
            });
    }

    /**
     * @param bool       $onlyActiveProduct
     * @param Contentset $set
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

    public function getShortNameAttribute($value)
    {
        return $this->small_name;
    }

    public function getTagsAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * Set the set's tag.
     *
     * @param array $value
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

        return isset($contentId) ? route('c.show', $contentId) : '';
    }

    public function getLastActiveContent(): Content
    {
        $key = 'set:getLastActiveContent:' . $this->cacheKey();

        return Cache::tags(['set', 'activeContent', 'lastActiveContent', 'set_' . $this->id, 'set_' . $this->id . '_contents', 'set_' . $this->id . '_activeContents', 'set_' . $this->id . '_lastActiveContent'])
            ->remember($key, config('constants.CACHE_300'), function () {

                $r = $this->getActiveContents();

                return $r->sortByDesc('order')
                    ->first() ?: new Content();
            });
    }

    public function getActiveContents(): ContentCollection
    {
        $key = 'set:getActiveContents:' . $this->cacheKey();

        return Cache::tags(['set', 'activeContent', 'set_' . $this->id, 'set_' . $this->id . '_contents', 'set_' . $this->id . '_activeContents'])
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

    public function oldContents()
    {
        return $this->belongsToMany(Content::class, 'contentset_educationalcontent', 'contentset_id', 'edc_id')
            ->withPivot('order', 'isDefault');
    }

    public function getShowUrlAttribute()
    {
        return route('set.show', $this->id);
    }

    public function getSetUrlAttribute($value): string
    {
        return route('set.show', $this->id);
    }

    public function getWebUrlAttribute($value): string
    {
        return route('set.show', $this->id);
    }

    public function getLastContent(): Content
    {
        $key = 'set:getLastContent:' . $this->cacheKey();

        return Cache::tags(['set', 'content', 'lastContent', 'set_' . $this->id, 'set_' . $this->id . '_contents', 'set_' . $this->id . '_lastContent'])
            ->remember($key, config('constants.CACHE_300'), function () {

                $r = $this->getContents();

                return $r->sortByDesc('order')
                    ->first() ?: new Content();
            });
    }

    public function getContents(): ContentCollection
    {
        $key = 'set:getContents:' . $this->cacheKey();

        return Cache::tags(['set', 'content', 'set_' . $this->id, 'set_' . $this->id . '_contents'])
            ->remember($key, config('constants.CACHE_300'), function () {

                $oldContentCollection = $this->oldContents()
                    ->get() ?: new ContentCollection();
                $newContentCollection = $this->contents()
                    ->get() ?: new ContentCollection();
                return $oldContentCollection->merge($newContentCollection);

            });
    }

    public function getApiUrlAttribute($value): array
    {
        return [
            'v1' => action("Api\SetController@show", $this),
        ];
    }

    public function getApiUrlV1Attribute()
    {
        return route('api.v1.set.show', $this);
    }

    public function getApiUrlV2Attribute($value)
    {
        return route('api.v2.set.show', $this);
    }

    /**
     * @param $value
     *
     * @return User|null
     */
    public function getAuthorAttribute($value): ?User
    {
        $content = $this->getLastActiveContent();

        if (is_null($content->author_id)) {
            return null;
        }

        $author = $content->author;
        return $author->setVisible([
            'id',
            'firstName',
            'lastName',
            'photo',
            'full_name',
        ]);
    }

    public function getEditLinkAttribute()
    {
//        if (hasAuthenticatedUserPermission(config('constants.EDIT_BLOCK_ACCESS')))
        return action('Web\SetController@edit', $this->id);
    }

    public function getRemoveLinkAttribute()
    {
//        if (hasAuthenticatedUserPermission(config('constants.REMOVE_BLOCK_ACCESS')))
//            return action('Web\BlockController@destroy', $this->id);

        return null;
    }

    /**
     * Get the content's meta title .
     *
     * @param $value
     *
     * @return string
     */
    public function getMetaTitleAttribute($value): string
    {
        if (isset($value[0])) {
            return $this->getCleanTextForMetaTags($value);
        }

        return mb_substr('فیلم و جزوه های ' . $this->getCleanTextForMetaTags($this->name) . ' | آلاء', 0,
            config('constants.META_TITLE_LIMIT'),
            'utf-8');
    }

    private function getCleanTextForMetaTags(string $text)
    {
        return Purify::clean($text, self::$purifyNullConfig);
    }

    /**
     * Get the content's meta description .
     *
     * @param $value
     *
     * @return string
     */
    public function getMetaDescriptionAttribute($value): string
    {
        if (isset($value[0])) {
            return $this->getCleanTextForMetaTags($value);
        }
        return mb_substr($this->getCleanTextForMetaTags($this->description . ' ' . $this->metaTitle),
            0, config('constants.META_TITLE_LIMIT'), 'utf-8');
    }

    public function getMetaTags(): array
    {
        return [
            'seoMod'      => SeoMetaTagsGenerator::SEO_MOD_GENERAL_TAGS,
            'title'       => $this->metaTitle,
            'description' => $this->metaDescription,
            'url'         => action([SetController::class, 'show'], $this),
            'canonical'   => action([SetController::class, 'show'], $this),
            'site'        => 'آلاء',
            'imageUrl'    => $this->photo,
            'imageWidth'  => '1280',
            'imageHeight' => '720',
        ];
    }
}
