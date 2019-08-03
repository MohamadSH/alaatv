<?php

namespace App;

use App\Collection\UserCollection;
use Eloquent;
use Exception;
use Carbon\Carbon;
use App\Classes\Taggable;
use App\Classes\Advertisable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;
use App\Classes\LinkGenerator;
use App\Traits\favorableTraits;
use App\Traits\APIRequestCommon;
use App\Classes\SEO\SeoInterface;
use App\Traits\ModelTrackerTrait;
use Illuminate\Support\Collection;
use App\Classes\FavorableInterface;
use App\Collection\ContentCollection;
use App\Collection\ProductCollection;
use Stevebauman\Purify\Facades\Purify;
use App\Classes\SEO\SeoMetaTagsGenerator;
use App\Traits\Content\TaggableContentTrait;
use Illuminate\Support\Facades\{Cache, Artisan};

/**
 * App\Content
 *
 * @property int         $id
 * @property int|null    $author_id       آی دی مشخص کننده به وجود
 *           آورنده اثر
 * @property int|null    $contenttype_id  آی دی مشخص کننده نوع
 *           محتوا
 * @property int|null    $template_id     آی دی مشخص کننده قالب
 *           این گرافیکی این محتوا
 * @property string|null $name            نام محتوا
 * @property string|null $description     توضیح درباره محتوا
 * @property string|null $metaTitle       متا تایتل محتوا
 * @property string|null $metaDescription متا دیسکریپشن محتوا
 * @property string|null $metaKeywords    متای کلمات کلیدی محتوا
 * @property string|null                                                 $tags            تگ ها
 * @property string|null                                                 $context         محتوا
 * @property int                                                         $order           ترتیب
 * @property int                                                         $enable          فعال یا غیر فعال بودن
 *           محتوا
 * @property string|null                                                 $validSince      تاریخ شروع استفاده از
 *           محتوا
 * @property Carbon|null                                                 $created_at
 * @property Carbon|null                                                 $updated_at
 * @property Carbon|null                                                 $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Contentset[]  $contentsets
 * @property-read Contenttype|null                                       $contenttype
 * @property-read \Illuminate\Database\Eloquent\Collection|Contenttype[] $contenttypes
 * @property-read \Illuminate\Database\Eloquent\Collection|File[]        $files
 * @property mixed                                                       $file
 * @property-read \Illuminate\Database\Eloquent\Collection|Grade[]       $grades
 * @property-read \Illuminate\Database\Eloquent\Collection|Major[]       $majors
 * @property-read Template|null                                          $template
 * @property-read User|null                                              $user
 * @method static Builder|Content active()
 * @method static Builder|Content enable($enable = 1)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Content onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Content soon()
 * @method static Builder|Content valid()
 * @method static Builder|Content whereAuthorId($value)
 * @method static Builder|Content whereContenttypeId($value)
 * @method static Builder|Content whereContext($value)
 * @method static Builder|Content whereCreatedAt($value)
 * @method static Builder|Content whereDeletedAt($value)
 * @method static Builder|Content whereDescription($value)
 * @method static Builder|Content whereEnable($value)
 * @method static Builder|Content whereId($value)
 * @method static Builder|Content whereMetaDescription($value)
 * @method static Builder|Content whereMetaKeywords($value)
 * @method static Builder|Content whereMetaTitle($value)
 * @method static Builder|Content whereName($value)
 * @method static Builder|Content whereOrder($value)
 * @method static Builder|Content whereTags($value)
 * @method static Builder|Content whereTemplateId($value)
 * @method static Builder|Content whereUpdatedAt($value)
 * @method static Builder|Content whereValidSince($value)
 * @method static \Illuminate\Database\Query\Builder|Content withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Content withoutTrashed()
 * @mixin Eloquent
 * @property-read mixed                                                       $display_name
 * @property string                                                           $duration        مدت زمان فیلم
 * @property array|null|string                                                $thumbnail       عکس هر محتوا
 * @property int                                                              $isFree          عکس هر محتوا
 * @property-read mixed                                                       $contentset
 * @property-read mixed                                                       $session
 * @method static Builder|Content whereDuration($value)
 * @method static Builder|Content whereFile($value)
 * @method static Builder|Content whereIsFree($value)
 * @method static Builder|Content whereThumbnail($value)
 * @property-read mixed                                                       $author
 * @property-read mixed                                                       $meta_description
 * @property-read mixed                                                       $meta_title
 * @property-read mixed                                                       $title
 * @property int|null                                                         $contentset_id
 * @property string|null                                                      $slug            slug
 * @property-read UserCollection|User[]                       $favoriteBy
 * @property-read Contentset|null                                             $set
 * @method static Builder|Content whereContentsetId($value)
 * @method static Builder|Content whereSlug($value)
 * @property mixed                                                            $page_view
 * @method static Builder|Content wherePageView($value)
 * @method static Builder|Content newModelQuery()
 * @method static Builder|Content newQuery()
 * @method static Builder|Content query()
 * @property-read mixed                                                       $author_name
 * @property-read mixed                                                       $url
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                       $api_url
 * @property mixed                                                            next_content
 * @property mixed                                                            previous_content
 * @property-read mixed                                                       $next_api_url
 * @property-read mixed                                                       $next_url
 * @property-read mixed                                                       $previous_api_url
 * @property-read mixed                                                       $previous_url
 * @property-read mixed                                                       $cache_cooldown_seconds
 */
class Content extends BaseModel implements Advertisable, Taggable, SeoInterface, FavorableInterface
{
    /*
    |--------------------------------------------------------------------------
    | Traits
    |--------------------------------------------------------------------------
    */
    use Searchable;
    use APIRequestCommon;
    use favorableTraits;
    use ModelTrackerTrait;
    use TaggableContentTrait;
    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    public const CONTENT_TYPE_PAMPHLET = 1;

    public const CONTENT_TYPE_EXAM = 2;

    public const CONTENT_TYPE_BOOK = 7;

    public const CONTENT_TYPE_VIDEO = 8;

    public const CONTENT_TYPE_ARTICLE = 9;

    public const CONTENT_TEMPLATE_VIDEO = 1;

    public const CONTENT_TEMPLATE_PAMPHLET = 2;

    public const CONTENT_TEMPLATE_EXAM = 2;

    protected static $purifyNullConfig = ['HTML.Allowed' => ''];

    /**      * The attributes that should be mutated to dates.        */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'validSince',
    ];

    protected $table = 'educationalcontents';

    protected $fillable = [
        'name',
        'description',
        'context',
        'file',
        'order',
        'validSince',
        'metaTitle',
        'metaDescription',
        'metaKeywords',
//        'tags',
        'author_id',
        'template_id',
        'contenttype_id',
        'contentset_id',
        'isFree',
        'enable',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'url',
        'apiUrl',
        'nextUrl',
        'nextApiUrl',
        'previousUrl',
        'previousApiUrl',
        'author',
    ];

    protected $hidden = [
        'user',
        'deleted_at',
        'validSince',
        'enable',
        'metaKeywords',
        'metaDescription',
        'metaTitle',
        'author_id',
        'template_id',
        'slug',
        'contentsets',
        'contentset_id',
        'template',
        'contenttype',

    ];

    /**
     * @return array
     */
    public static function videoFileCaptionTable(): array
    {
        return [
            '240p' => 'کیفیت متوسط',
            '480p' => 'کیفیت بالا',
            '720p' => 'کیفیت عالی',
        ];
    }

    public static function pamphletFileCaption(): string
    {
        return 'جزوه';
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
        $array      = $this->toArray();
        $unSetArray = [
            'basePrice',
            'user',
            'deleted_at',
            'validSince',
            'enable',
            'metaKeywords',
            'metaDescription',
            'metaTitle',
            'author_id',
            'template_id',
            'slug',
            'contentset_id',
            'template',
            'contenttype',
            'url',
            'apiUrl',
            'nextUrl',
            'nextApiUrl',
            'previousUrl',
            'previousApiUrl',
            'author',
            'file',
            'order',
            'validSince',
            'metaTitle',
            'metaDescription',
            'metaKeywords',
            'tags',
            'author_id',
            'template_id',
            'contenttype_id',
            'contentset_id',
            'isFree',
            'enable',
            'created_at',
            'updated_at',
            'deleted_at',
            'validSince',
            'page_view',
            'thumbnail',
        ];
        foreach ($unSetArray as $key) {
            unset($array[$key]);
        }
        return $array;
    }

    /*
    |--------------------------------------------------------------------------
    | Private methods
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | Cache
    |--------------------------------------------------------------------------
    */

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = [])
    {
        return new ContentCollection($models);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Scope a query to only include enable(or disable) Contents.
     *
     * @param  Builder  $query
     * @param  int                                    $enable
     *
     * @return Builder
     */
    public function scopeEnable($query, $enable = 1)
    {
        return $query->where('enable', $enable);
    }

    /**
     * Scope a query to only include Valid Contents.
     *
     * @param  Builder  $query
     *
     * @return Builder
     */
    public function scopeValid($query)
    {
        return $query->where('validSince', '<', Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())
            ->timezone('Asia/Tehran'))
            ->orWhereNull('validSince');
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
        return $query->enable()
            ->valid();
    }

    public function scopeFree($query)
    {
        return $query->where('isFree', 1);
    }

    /**
     * Scope a query to only include Contents that will come soon.
     *
     * @param  Builder  $query
     *
     * @return Builder
     */
    public function scopeSoon($query)
    {
        return $query->where('validSince', '>', Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())
            ->timezone('Asia/Tehran'));
    }

    public function scopeType($query , $type){
        return $query->where('contenttype_id' , $type);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessor
    |--------------------------------------------------------------------------
    */

    public function getUrlAttribute($value): string
    {
        return action("Web\ContentController@show", $this);
    }

    public function getPreviousUrlAttribute($value)
    {
        return ($this->getPreviousContent() ?: new Content())->url;
    }

    public function getPreviousContent()
    {
        $key = 'Content:previousContent'.$this->cacheKey();

        return Cache::tags('content')
            ->remember($key, config('constants.CACHE_600'), function () {
                $previousContentOrder = $this->order - 1;
                $set                  = $this->set;
                if (isset($set)) {
                    $previousContent = $set->oldContents()
                        ->where('educationalcontents.order', $previousContentOrder)
                        ->get()
                        ->first();
                }

                return isset($previousContent) ? $previousContent : null;
            });
    }

    public function getNextUrlAttribute($value)
    {
        return ($this->getNextContent() ?: new Content())->url;
    }

    public function getNextContent()
    {
        $key = 'Content:nextContent'.$this->cacheKey();

        return Cache::tags('content')
            ->remember($key, config('constants.CACHE_600'), function () {
                $nextContentOrder = $this->order + 1;
                $set              = $this->set;
                if (isset($set)) {
                    $nextContent = $set->oldContents()
                        ->where('educationalcontents.order', $nextContentOrder)
                        ->get()
                        ->first();
                }

                return ($nextContent) ?? null;
            });
    }

    public function getApiUrlAttribute($value): array
    {
        return [
            'v1' => action("Api\ContentController@show", $this),
        ];
    }

    public function getPreviousApiUrlAttribute($value)
    {
        return ($this->getPreviousContent() ?: new Content())->api_url;
    }

    public function getNextApiUrlAttribute($value)
    {
        return ($this->getNextContent() ?: new Content())->api_url;
    }

    /**
     * Get the content's title .
     *
     * @param $value
     *
     * @return string
     */
    public function getTitleAttribute($value): string
    {
        return Purify::clean($value, self::$purifyNullConfig);
    }

    /**
     * Get the content's description .
     *
     * @param $value
     *
     * @return string
     */
    public function getDescriptionAttribute($value): string
    {
        return Purify::clean($value);
    }

    /**
     * Get the content's name .
     *
     * @param $value
     *
     * @return string
     */
    public function getNameAttribute($value): string
    {
        return Purify::clean($value, self::$purifyNullConfig);
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
            return Purify::clean($value, self::$purifyNullConfig);
        }

        return Purify::clean(mb_substr($this->display_name, 0, config('constants.META_TITLE_LIMIT'), 'utf-8'),
            self::$purifyNullConfig);
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
            return Purify::clean($value, self::$purifyNullConfig);
        }

        return Purify::clean(mb_substr($this->description, 0, config('constants.META_DESCRIPTION_LIMIT'), 'utf-8'),
            self::$purifyNullConfig);
    }

    /**
     * Get the content's files .
     *
     * @param $value
     *
     * @return Collection
     */
    public function getFileAttribute($value): ?Collection
    {
        $key = 'Content:File'.$this->cacheKey();

        return Cache::tags('content')
            ->remember($key, config('constants.CACHE_60'), function () use ($value) {
                $fileCollection = collect(json_decode($value));
                $fileCollection->transform(function ($item, $key) {
//                dd($item);
                    $l          = new LinkGenerator($item);
                    $item->link = $this->isFree ? $l->getLinks() : $l->getLinks([
                        'content_id' => $this->id,
                    ]);
                    unset($item->url);
                    unset($item->disk);
                    unset($item->fileName);
                    if ($item->type === 'pamphlet') {
                        unset($item->res);
                    }
                    return $item;
                });


                return $fileCollection->count() > 0 ? $fileCollection->groupBy('type') : null;
            });
    }

    /**
     * Get the content's files for admin.
     *
     * @param $value
     *
     * @return Collection
     */

    public function getFileForAdminAttribute(): ?Collection
    {
        $value = $this->getOriginal('file');
        $fileCollection = collect(json_decode($value));
        $fileCollection->transform(function ($item) {
//                dd($item);
            $l          = new LinkGenerator($item);
            $item->link = $this->isFree ? $l->getLinks() : $l->getLinks([
                'content_id' => $this->id,
            ]);

            if ($item->type === 'pamphlet') {
                unset($item->res);
            }
            return $item;
        });


        return $fileCollection->count() > 0 ? $fileCollection->groupBy('type') : null;
    }

    /**
     * Get the content's thumbnail .
     *
     * @param $value
     *
     * @return array|null|string
     *
     * @throws Exception
     */
    public function getThumbnailAttribute($value)
    {
        $t    = json_decode($value);
        $link = null;
        if (isset($t)) {
            $link = new LinkGenerator($t);
        }

        $defaultImage = $this->contenttype_id === self::CONTENT_TYPE_VIDEO ? 'https://cdn.sanatisharif.ir/media/thumbnails/Alaa_Narenj.jpg' : null;
        if ($link === null) {
            return $defaultImage;
        }
        return $link->getLinks() ?: $defaultImage;
    }

    /**
     * Get the content's author .
     *
     * @return User
     */
    public function getAuthorAttribute(): User
    {
        $content = $this;
        $key     = 'content:author'.$content->cacheKey();

        return Cache::tags(['user'])
            ->remember($key, config('constants.CACHE_600'), function () use ($content) {

                $visibleArray = [
                    'id',
                    'firstName',
                    'lastName',
                    'photo',
                    'full_name',
                ];
                $user         = $this->user ?: User::getNullInstant($visibleArray);
                return $user->setVisible($visibleArray);
            });
    }

    public function getAuthorNameAttribute(): string
    {
        $author = $this->author;
        return isset($author) ? $author->full_name : '';
    }

    /**
     * Get the content's tags .
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
     * Get the content's session .
     *
     * @return int|null
     */
    public function getSessionAttribute()
    {
        return $this->order;
    }

    /**
     * Gets content's pamphlets
     *
     * @return Collection
     */
    public function getPamphlets(): Collection
    {
        $file = $this->file;
        if (is_null($file)) {
            return null;
        }
        $pamphlet = $file->get('pamphlet');

        return isset($pamphlet) ? $pamphlet : collect();
    }

    /**
     * Gets content's videos
     *
     * @return Collection
     */
    public function getVideos(): Collection
    {
        $file = $this->file;
        if ($file === null) {
            return collect();
        }
        $video = $file->get('video');

        return isset($video) ? $video : collect();
    }

    /**
     * Gets content's set mates (contents which has same content set as this content
     *
     * @return mixed
     */
    public function getSetMates()
    {
        $content = $this;
        $key     = 'content:setMates:'.$this->cacheKey();

        $setMates = Cache::tags(['content'])
            ->remember($key, config('constants.CACHE_60'), function () use ($content) {
                $contentSet     = $content->set;
                $contentSetName = isset($contentSet) ? $contentSet->name : null;
                if (isset($contentSet)) {
                    $sameContents = $contentSet->getActiveContents()
                        ->sortBy('order')
                        ->load('contenttype');
                } else {
                    $sameContents = new ContentCollection([]);
                }

                return [
                    $sameContents,
                    $contentSetName,
                ];
            });

        return $setMates;
    }

    /**
     * Gets content's display name
     *
     * @return string
     * @throws Exception
     */
    public function getDisplayNameAttribute(): string
    {
        try {
            $key = 'content:getDisplayName'.$this->cacheKey();
            $c   = $this;

            return Cache::remember($key, config('constants.CACHE_60'), function () use ($c) {
                $displayName   = '';
                $sessionNumber = $c->order;
                if (isset($c->contenttype)) {
                    $displayName .= $c->contenttype->displayName.' ';
                }
                $displayName .= (isset($sessionNumber) && $sessionNumber > -1 ? 'جلسه '.$sessionNumber.' - ' : '').' '.(isset($c->name) ? $c->name : $c->user->name);

                return $displayName;
            });
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Gets content's advertisement items
     *
     * @return Collection
     */
    public function getAddItems(): Collection
    {
        $content = $this;
        $key     = 'content:getAddItems'.$content->cacheKey();

        $adItems = Cache::tags(['content'])
            ->remember($key, config('constants.CACHE_60'), function () use ($content) {
                $adItems = collect();
                $set     = $content->set ?: new Contentset();
                if ($set->id != 199) {
                    $adItems = Contentset::findOrFail(199)
                        ->oldContents()
                        ->where('enable', 1)
                        ->orderBy('order')
                        ->get();
                }

                return $adItems;
            });

        return $adItems;
    }

    /**
     * Gets content's meta tags array
     *
     * @return array
     */
    public function getMetaTags(): array
    {
        $file           = $this->file ?: collect();
        $videoDirectUrl = $file->where('res', '480p') ?: collect();
        $videoDirectUrl = $videoDirectUrl->first();
        $videoDirectUrl = isset($videoDirectUrl) ? $videoDirectUrl->link : null;
        return [
            'title'            => $this->metaTitle,
            'description'      => $this->metaDescription,
            'url'              => action('Web\ContentController@show', $this),
            'canonical'        => action('Web\ContentController@show', $this),
            'site'             => 'آلاء',
            'imageUrl'         => $this->thumbnail,
            'imageWidth'       => '1280',
            'imageHeight'      => '720',
            'seoMod'           => SeoMetaTagsGenerator::SEO_MOD_VIDEO_TAGS,
            'playerUrl'        => action('Web\ContentController@embed', $this),
            'playerWidth'      => '854',
            'playerHeight'     => '480',
            'videoDirectUrl'   => $videoDirectUrl,
            'videoActorName'   => $this->authorName,
            'videoActorRole'   => 'دبیر',
            'videoDirector'    => 'آلاء',
            'videoWriter'      => 'آلاء',
            'videoDuration'    => $this->duration,
            'videoReleaseDate' => $this->validSince,
            'tags'             => $this->tags,
            'videoWidth'           => '854',
            'videoHeight'          => '480',
            'videoType'            => 'video/mp4',
            'articleAuthor'        => $this->authorName,
            'articleModifiedTime'  => $this->updated_at,
            'articlePublishedTime' => $this->validSince,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Mutator
    |--------------------------------------------------------------------------
    */

    /**
     *  Converts content's validSince to Jalali
     *
     * @return string
     */
    public function validSince_Jalali(): string
    {
        $explodedDateTime = explode(' ', $this->validSince);
        $explodedTime     = $explodedDateTime[1];

        return $this->convertDate($this->validSince, 'toJalali').' '.$explodedTime;
    }

    /**
     * Set the content's thumbnail.
     *
     * @param $input
     *
     * @return void
     */
    public function setThumbnailAttribute($input)
    {
        $this->attributes['thumbnail'] = json_encode($input, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Set the content's file.
     *
     * @param  Collection  $input
     *
     * @return void
     */
    public function setFileAttribute(Collection $input = null)
    {
        $this->attributes['file'] = optional($input)->toJson(JSON_UNESCAPED_UNICODE);
    }


    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

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
     * every products that have this content.
     *
     * @return ProductCollection
     */
    public function activeProducts(): ProductCollection
    {
        return Cache::tags(['content', 'product'])
            ->remember('products-of-content:'.$this->id, config('constants.CACHE_60'), function () {
                return $this->set->getProducts()
                    ->makeHidden([
                        'shortDescription',
                        'longDescription',
                        'tags',
                        'introVideo',
                        'order',
                        'page_view',
                        'gift',
                        'type',
                        'attributes',
                        'samplePhotos',
                        'sets',
                        'product_set',
                        'children',
                        'updated_at',
                        'amount',

                    ]);
            });

    }

    /**
     * every products that have this content.
     *
     * @return ProductCollection
     */
    public function allProducts(): ProductCollection
    {
        return Cache::tags(['content', 'product'])
            ->remember('all-of-products-of-content:'.$this->id, config('constants.CACHE_60'), function () {
                return $this->set->getProducts(false)
                    ->makeHidden([
                        'shortDescription',
                        'longDescription',
                        'tags',
                        'introVideo',
                        'order',
                        'page_view',
                        'gift',
                        'type',
                        'attributes',
                        'samplePhotos',
                        'sets',
                        'product_set',
                        'children',
                        'updated_at',
                        'amount',

                    ]);
            });

    }


    public function grades()
    {
        //ToDo : deprecated
        return $this->belongsToMany('App\Grade');
    }

    public function majors()
    {
        //ToDo : deprecated
        return $this->belongsToMany('App\Major');
    }

    public function thumbnails()
    {
        return $this->files()
            ->where('label', '=', 'thumbnail');
    }

    public function files()
    {
        return $this->belongsToMany('App\File', 'educationalcontent_file', 'content_id', 'file_id')
            ->withPivot('caption', 'label');
    }

    public function contentsets()
    {
        //ToDo : deprecated
        return $this->belongsToMany("\App\Contentset", 'contentset_educationalcontent', 'edc_id', 'contentset_id')
            ->withPivot('order', 'isDefault');
    }

    public function template()
    {
        return $this->belongsTo("\App\Template")
            ->withDefault();
    }

    public function contenttype()
    {
        return $this->belongsTo('App\Contenttype')
            ->withDefault();
    }

    public function user()
    {
        return $this->belongsTo("\App\User", 'author_id', 'id')
            ->withDefault();
    }

    /*
    |--------------------------------------------------------------------------
    |  Checkers (boolean)
    |--------------------------------------------------------------------------
    */

    /**
     * Get the content's contentset .
     *
     * @return Contentset|BelongsTo
     */
    public function set()
    {
        return $this->belongsTo('\App\Contentset', 'contentset_id', 'id')
            ->withDefault([
                'id'         => 0,
                'url'        => null,
                'apiUrl'     => [
                    'v1' => null,
                ],
                'shortName'  => null,
                'author'     => [
                    'full_name' => null,
                ],
                'contentUrl' => null,
            ]);
    }

    /**
     * Fixes contents files (used in
     * /database/migrations/2018_08_21_143144_alter_table_educationalcontents_add_columns.php)
     *
     * @retuen void
     */
    public function fixFiles(): void
    {
        $content = $this;
        $files   = collect();
        switch ($content->template->name) {
            case 'video1':
                $file = $content->files->where('pivot.label', 'hd')
                    ->first();
                if (isset($file)) {
                    $url     = $file->name;
                    $size    = null;
                    $caption = $file->pivot->caption;
                    $res     = '720p';
                    $type    = 'video';

                    $files->push([
                        'uuid'     => $file->uuid,
                        'disk'     => 'alaaCdnSFTP',
                        'url'      => $url,
                        'fileName' => parse_url($url)['path'],
                        'size'     => $size,
                        'caption'  => $caption,
                        'res'      => $res,
                        'type'     => $type,
                        'ext'      => pathinfo(parse_url($url)['path'], PATHINFO_EXTENSION),
                    ]);
                }

                $file = $content->files->where('pivot.label', 'hq')
                    ->first();
                if (isset($file)) {
                    $url     = $file->name;
                    $size    = null;
                    $caption = $file->pivot->caption;
                    $res     = '480p';
                    $type    = 'video';

                    $files->push([
                        'uuid'     => $file->uuid,
                        'disk'     => 'alaaCdnSFTP',
                        'url'      => $url,
                        'fileName' => parse_url($url)['path'],
                        'size'     => $size,
                        'caption'  => $caption,
                        'res'      => $res,
                        'type'     => $type,
                        'ext'      => pathinfo(parse_url($url)['path'], PATHINFO_EXTENSION),
                    ]);
                }

                $file = $content->files->where('pivot.label', '240p')
                    ->first();
                if (isset($file)) {
                    $url     = $file->name;
                    $size    = null;
                    $caption = $file->pivot->caption;
                    $res     = '240p';
                    $type    = 'video';

                    $files->push([
                        'uuid'     => $file->uuid,
                        'disk'     => 'alaaCdnSFTP',
                        'url'      => $url,
                        'fileName' => parse_url($url)['path'],
                        'size'     => $size,
                        'caption'  => $caption,
                        'res'      => $res,
                        'type'     => $type,
                        'ext'      => pathinfo(parse_url($url)['path'], PATHINFO_EXTENSION),
                    ]);
                }

                $file = optional($content->files->where('pivot.label', 'thumbnail')
                    ->first());

                $url = $file->name;
                if (isset($url)) {
                    $size = null;
                    $type = 'thumbnail';

                    $this->thumbnail = [
                        'uuid'     => $file->uuid,
                        'disk'     => 'alaaCdnSFTP',
                        'url'      => $url,
                        'fileName' => parse_url($url)['path'],
                        'size'     => $size,
                        'caption'  => null,
                        'res'      => null,
                        'type'     => $type,
                        'ext'      => pathinfo(parse_url($url)['path'], PATHINFO_EXTENSION),
                    ];
                }
                break;

            case  'pamphlet1':
                $pFiles = $content->files;
                foreach ($pFiles as $file) {
                    $type    = 'pamphlet';
                    $res     = null;
                    $caption = 'فایل'.' '.$file->pivot->caption;

                    if ($file->disks->isNotEmpty()) {
                        $disk     = $file->disks->first();
                        $diskName = $disk->name;
                    }

                    $files->push([
                        'uuid'     => $file->uuid,
                        'disk'     => (isset($diskName) ? $diskName : null),
                        'url'      => null,
                        'fileName' => $file->name,
                        'size'     => null,
                        'caption'  => $caption,
                        'res'      => $res,
                        'type'     => $type,
                        'ext'      => pathinfo($file->name, PATHINFO_EXTENSION),
                    ]);
                }
                break;
            case 'article' :
                break;
            default:
                break;
        }

        //        dd($files);
        $this->file = $files;
        $this->updateWithoutTimestamp();

        Artisan::call('cache:clear');
    }



    /*
    |--------------------------------------------------------------------------
    | Static methods
    |--------------------------------------------------------------------------
    */



    /**
     * Checks whether the content is active or not .
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return ($this->isEnable() && $this->isValid() ? true : false);
    }

    /**
     * Checks whether the content is enable or not .
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
     * Checks whether the content is valid or not .
     *
     * @return bool
     */
    public function isValid(): bool
    {
        if ($this->validSince === null || $this->validSince < Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())
                ->timezone('Asia/Tehran')) {
            return true;
        }

        return false;
    }


    public function getEditLinkAttribute()
    {
//        if (hasAuthenticatedUserPermission(config('constants.EDIT_BLOCK_ACCESS')))
        return action('Web\ContentController@edit', $this->id);

        return null;
    }

    public function getRemoveLinkAttribute()
    {
//        if (hasAuthenticatedUserPermission(config('constants.REMOVE_BLOCK_ACCESS')))
//            return action('Web\ContentController@destroy', $this->id);

        return null;
    }

}
