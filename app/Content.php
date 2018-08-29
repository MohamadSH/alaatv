<?php

namespace App;

use App\Classes\Advertisable;
use App\Classes\LinkGenerator;
use App\Classes\SEO\SeoInterface;
use App\Classes\SEO\SeoMetaTagsGenerator;
use App\Classes\Taggable;
use App\Collection\ContentCollection;
use App\Traits\APIRequestCommon;
use App\Traits\FileCommon;
use App\Traits\Helper;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Stevebauman\Purify\Facades\Purify;

/**
 * App\Content
 *
 * @property int $id
 * @property int|null $author_id آی دی مشخص کننده به وجود آورنده اثر
 * @property int|null $contenttype_id آی دی مشخص کننده نوع محتوا
 * @property int|null $template_id آی دی مشخص کننده قالب این گرافیکی این محتوا
 * @property string|null $name نام محتوا
 * @property string|null $description توضیح درباره محتوا
 * @property string|null $metaTitle متا تایتل محتوا
 * @property string|null $metaDescription متا دیسکریپشن محتوا
 * @property string|null $metaKeywords متای کلمات کلیدی محتوا
 * @property string|null $tags تگ ها
 * @property string|null $context محتوا
 * @property int $order ترتیب
 * @property int $enable فعال یا غیر فعال بودن محتوا
 * @property string|null $validSince تاریخ شروع استفاده از محتوا
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Contentset[] $contentsets
 * @property-read \App\Contenttype|null $contenttype
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Contenttype[] $contenttypes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\File[] $files
 * @property-read mixed $file
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Grade[] $grades
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Major[] $majors
 * @property-read \App\Template|null $template
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content enable($enable = 1)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Content onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content soon()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content valid()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereContenttypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereContext($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereValidSince($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Content withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Content withoutTrashed()
 * @mixin \Eloquent
 * @property-read mixed $display_name
 * @property string $duration مدت زمان فیلم
 * @property array|null|string $thumbnail عکس هر محتوا
 * @property int $isFree عکس هر محتوا
 * @property-read mixed $contentset
 * @property-read mixed $session
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereIsFree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Content whereThumbnail($value)
 * @property-read mixed $author
 * @property-read mixed $meta_description
 * @property-read mixed $meta_title
 * @property-read mixed $title
 */
class Content extends Model implements Advertisable, Taggable, SeoInterface
{
    use APIRequestCommon;
    use SoftDeletes;
    use Helper;
    protected static $purifyNullConfig = ['HTML.Allowed' => ''];

    /**      * The attributes that should be mutated to dates.        */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'validSince'
    ];

    protected $table = "educationalcontents";

    protected $fillable = [
        'name',
        'description',
        'context',
        'file',
        'order',
        'validSince',
        'template_id',
        'metaTitle',
        'metaDescription',
        'metaKeywords',
        'tags',
        'author_id',
        'contenttype_id'
    ];


    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array $models
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = [])
    {
        return new ContentCollection($models);
    }


    public function getPamphlets() :Collection{
        return optional($this->file)->get('pamphlet');
    }
    public function getVideos() :Collection{
        return optional($this->file)->get('video');
    }
    /**
     *
     */
    public function fixFiles()
    {
        $content = $this;
        $files = collect();
        $this->timestamps = false;
        switch ($content->template->name) {
            case "video1":
                $file = $content->files->where("pivot.label", "hd")->first();
                if (isset($file)) {
                    $url = $file->name;
                    $size = null;
                    $caption = $file->pivot->caption;
                    $res = "720p";
                    $type = "video";


                    $files->push([
                        "uuid" => $file->uuid,
                        "disk" => "alaaCdnSFTP",
                        "url" => $url,
                        "fileName" =>parse_url($url)['path'],
                        "size" => $size,
                        "caption" => $caption,
                        "res" => $res,
                        "type" => $type,
                        "ext"  => pathinfo(parse_url($url)['path'],PATHINFO_EXTENSION)
                    ]);
                }

                $file = $content->files->where("pivot.label", "hq")->first();
                if (isset($file)) {
                    $url = $file->name;
                    $size = null;
                    $caption = $file->pivot->caption;
                    $res = "480p";
                    $type = "video";

                    $files->push([
                        "uuid" => $file->uuid,
                        "disk" => "alaaCdnSFTP",
                        "url" => $url,
                        "fileName" =>parse_url($url)['path'],
                        "size" => $size,
                        "caption" => $caption,
                        "res" => $res,
                        "type" => $type,
                        "ext"  => pathinfo(parse_url($url)['path'],PATHINFO_EXTENSION)
                    ]);
                }


                $file = $content->files->where("pivot.label", "240p")->first();
                if (isset($file)) {
                    $url = $file->name;
                    $size = null;
                    $caption = $file->pivot->caption;
                    $res = "240p";
                    $type = "video";

                    $files->push([
                        "uuid" => $file->uuid,
                        "disk" => "alaaCdnSFTP",
                        "url" => $url,
                        "fileName" =>parse_url($url)['path'],
                        "size" => $size,
                        "caption" => $caption,
                        "res" => $res,
                        "type" => $type,
                        "ext"  => pathinfo(parse_url($url)['path'],PATHINFO_EXTENSION)
                    ]);
                }


                $file = optional($content->files->where("pivot.label", "thumbnail")->first());

                $url = $file->name;
                if(isset($url))
                {
                    $size = null;
                    $type = "thumbnail";

                    $this->thumbnail = [
                        "uuid" => $file->uuid,
                        "disk" => "alaaCdnSFTP",
                        "url" => $url,
                        "fileName" =>parse_url($url)['path'],
                        "size" => $size,
                        "caption" => null,
                        "res" => null,
                        "type" => $type,
                        "ext"  => pathinfo(parse_url($url)['path'],PATHINFO_EXTENSION)
                    ];
                }
                break;

            case  "pamphlet1":
                $pFiles = $content->files;
                foreach ($pFiles as $file) {
                    $type = "pamphlet";
                    $res = null;
                    $caption = "فایل" .' '. $file->pivot->caption;

                    if ($file->disks->isNotEmpty()) {
                        $disk = $file->disks->first();
                        $diskName = $disk->name;
                    }

                    $files->push([
                        "uuid" => $file->uuid,
                        "disk" => (isset($diskName) ? $diskName : null),
                        "url" => null,
                        "fileName" => $file->name,
                        "size" => null,
                        "caption" => $caption,
                        "res"  => $res,
                        "type" => $type,
                        "ext"     => pathinfo($file->name,PATHINFO_EXTENSION)
                    ]);

                }
                break;
            case "article" :
                break;
            default:
                break;

        }


//        dd($files);
        $this->file = $files;
        $this->update();
        $this->timestamps = true;

        Artisan::call('cache:clear');
    }

    public function getTitleAttribute($value){
        return Purify::clean($value,self::$purifyNullConfig);
    }
    public function getDescriptionAttribute($value){
        return Purify::clean($value);
    }
    public function getNameAttribute($value){
        return Purify::clean($value,self::$purifyNullConfig);
    }
    public function getMetaTitleAttribute($value){
        if(isset($value[0]))
            return Purify::clean($value,self::$purifyNullConfig);
        else{
            return Purify::clean(mb_substr($this->display_name,0,config("constants.META_TITLE_LIMIT"), "utf-8"),self::$purifyNullConfig);
        }
    }
    public function getMetaDescriptionAttribute($value){
        if(isset($value[0]))
            return Purify::clean($value,self::$purifyNullConfig);
        else{
            return Purify::clean(mb_substr($this->description,0,config("constants.META_DESCRIPTION_LIMIT"), "utf-8"),self::$purifyNullConfig);
        }
    }
    /**
     * @return null|string|\Symfony\Component\HttpFoundation\StreamedResponse
     * @throws Exception
     */
    public function test()
    {

//        $l = new LinkGenerator($this->file[0]);
//        try {
//            return $l->getLinks();
//        } catch (Exception $e) {
//            throw $e;
//        }
    }

    public function grades()
    {
        return $this->belongsToMany('App\Grade');
    }

    public function majors()
    {
        return $this->belongsToMany('App\Major');
    }

    /**
     * @param $value
     * @return Collection
     */
    public function getFileAttribute($value)
    {
        $key = "Content:File".$this->cacheKey();
        return Cache::tags('content')->remember($key,Config::get("constants.CACHE_60"),function () use($value) {
            $fileCollection = collect(json_decode($value));
            $fileCollection->transform(function ($item, $key) {
                $l = new LinkGenerator($item);
                $item->link = $this->isFree ? $l->getLinks() : $l->getLinks([
                                                                    "content_id" => $this->id
                                                                ]);
                return $item;
            });

            return $fileCollection->groupBy('type');
        });
    }

    /**
     * @param $value
     * @return array|null|string
     *
     * @throws Exception
     */
    public function getThumbnailAttribute($value){
        $t = json_decode($value);
        $link = null;
        if(isset($t))
            $link = new LinkGenerator($t);
        return optional($link)->getLinks();
    }

    public function setThumbnailAttribute($input){
        $this->attributes['thumbnail'] = json_encode($input,JSON_UNESCAPED_UNICODE);
    }

    public function setFileAttribute(Collection $input)
    {
        $this->attributes['file'] = $input->toJson(JSON_UNESCAPED_UNICODE);
    }

    public function files()
    {
        return $this->belongsToMany(
            'App\File',
            'educationalcontent_file',
            'content_id',
            'file_id')->withPivot("caption", "label");
    }

    public function thumbnails(){
        return $this->files()->where('label','=','thumbnail');
    }

    public function sources(){
        return $this->files()->where('label','<>','thumbnail');
    }

    public function contentsets()
    {
        return $this->belongsToMany("\App\Contentset", "contentset_educationalcontent", "edc_id", "contentset_id")->withPivot("order", "isDefault");
    }

    public function template()
    {
        return $this->belongsTo("\App\Template");
    }

    public function user()
    {
        return $this->belongsTo("\App\User" , "author_id" ,"id");
    }

    /**
     * @return string
     * Converting Created_at field to jalali
     */
    public function CreatedAt_Jalali()
    {
        $explodedDateTime = explode(" ", $this->created_at);
//        $explodedTime = $explodedDateTime[1] ;
        return $this->convertDate($this->created_at, "toJalali");
    }

    /**
     * @return string
     * Converting Updated_at field to jalali
     */
    public function UpdatedAt_Jalali()
    {
        $explodedDateTime = explode(" ", $this->updated_at);
//        $explodedTime = $explodedDateTime[1] ;
        return $this->convertDate($this->updated_at, "toJalali");
    }

    /**
     * @return string
     * Converting Created_at field to jalali
     */
    public function validSince_Jalali()
    {
        $explodedDateTime = explode(" ", $this->validSince);
        $explodedTime = $explodedDateTime[1];
        return $this->convertDate($this->validSince, "toJalali") . " " . $explodedTime;
    }

    public function isActive(): bool
    {
        return ($this->isEnable() && $this->isValid() ? true : false);
    }

    public function isValid(): bool
    {
        if ($this->validSince < Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'))
            return true;
        return false;
    }

    public function isEnable(): bool
    {
        if ($this->enable)
            return true;
        return false;
    }

    /**
     * Scope a query to only include enable(or disable) Contents.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $enable
     * @return \Illuminate\Database\Eloquent\Builder
     */

    public function scopeEnable($query, $enable = 1)
    {
        return $query->where('enable', $enable);
    }

    /**
     * Scope a query to only include Valid Contents.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeValid($query)
    {
        return $query->where('validSince', '<', Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'));
    }

    public function scopeActive($query){
        return $query->where('enable', 1)
            ->where('validSince', '<', Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())
                ->timezone('Asia/Tehran')
            );
    }

    /**
     * Scope a query to only include Contents that will come soon.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSoon($query)
    {
        return $query->where('validSince', '>', Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'));
    }

    public function contentsWithSameType($enable = 1, $valid = 1)
    {
        $contentsWithSameType = Content::where("id", "<>", $this->id);
        if ($enable) $contentsWithSameType = $contentsWithSameType->enable();
        if ($valid) $contentsWithSameType = $contentsWithSameType->valid();
        $contentTypes = $this->contenttypes->pluck("id")->toArray();
        foreach ($contentTypes as $id) {
            $contentsWithSameType = $contentsWithSameType->whereHas("contenttypes", function ($q) use ($id) {
                $q->where("id", $id);
            });
        }
        return $contentsWithSameType;
    }

    /**
     * @return mixed
     * @throws Exception
     */

    public  function getOrder(){
        $key = "content:Order"
            .$this->cacheKey();
        $c = $this;
        return Cache::tags("content")->remember($key,Config::get("constants.CACHE_60"),function () use($c) {
            $order = optional($c->contentset)->pivot->order;
            return  $order >= 0 ? $order : -1;
        });
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function getDisplayNameAttribute()
    {
        try {
            $key = "content:getDisplayName"
                .$this->cacheKey();
            $c = $this;
            return Cache::remember($key,Config::get("constants.CACHE_60"),function () use($c) {
                $displayName = "";
                $sessionNumber = $c->getOrder();
                if (isset($c->contenttype)) {
                    $displayName .=$c->contenttype->displayName." ";
                }
                $displayName .= ( isset($sessionNumber) && $sessionNumber > -1 ? "جلسه ".$sessionNumber." - ":"" )." ".(isset($c->name) ? $c->name : $c->user->name);
                return $displayName;
            });

        } catch (Exception $e) {
            throw $e;
        }
    }

    public function contenttype()
    {
        return $this->belongsTo('App\Contenttype');
    }

    public function displayMajors()
    {
        $displayMajors = "";
        foreach ($this->majors as $major) {
            if (count($this->majors) > 1 && $major->id != $this->majors->last()->id)
                $displayMajors .= $major->name . " / ";
            else
                $displayMajors .= $major->name . " ";
        }
        return $displayMajors;
    }

    public function getFilesUrl()
    {
        $files = $this->files;
        $links = collect();
        foreach ($files as $file) {
            $url = $file->getUrl();
            if (isset($url[0]))
                $links->push($url);
        }
        return $links;
    }

    public function getTagsAttribute($value)
    {
        return json_decode($value);
    }

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

    public function getContentsetAttribute()
    {
        $content = $this;
        $key = "content:contentSet:" . $this->cacheKey();
        $contentset = Cache::tags(["content"])->remember($key, Config::get("constants.CACHE_60"), function () use ($content) {
            return $content->contentsets->where("pivot.isDefault", 1)->first();
        });
        return $contentset;
    }

    public function getSessionAttribute()
    {
        $content = $this;
        $order = optional($this->pivot)->order;
        if(isset($order))
            return $order;

        $key = "content:session:" . $this->cacheKey();
        $session = Cache::tags(["content"])->remember($key, Config::get("constants.CACHE_60"), function () use ($content) {
            $cs = $content->contentset;
            return isset($cs) ? $cs->pivot->order : null;
        });
        return $session;
    }

    public function getSetMates()
    {
        $content = $this;
        $key = "content:setMates:" . $this->cacheKey();

        $setMates = Cache::tags(["content"])->remember($key, Config::get("constants.CACHE_60"), function () use ($content) {
            $contentSet = $content->contentset;
            $sameContents = optional($contentSet)->contents()
                ->active()
                ->get()
                ->sortBy("pivot.order")
                ->load('contenttype');
            return [
                $sameContents,
                optional($contentSet)->name,
            ];
        });
        return $setMates;

    }

    public function retrievingTags()
    {
        /**
         *      Retrieving Tags
         */
        $response = $this->sendRequest(
            config("constants.TAG_API_URL")."id/content/".$this->id,
            "GET"
        );

        if($response["statusCode"] == 200) {
            $result = json_decode($response["result"]);
            $tags = $result->data->tags;
        } else {
            $tags =[];
        }

        return $tags ;
    }

    public function getAddItems(): Collection
    {
        $content = $this;
        $key = "content:getAddItems" . $content->cacheKey();

        $adItems = Cache::tags(["content"])->remember($key, Config::get("constants.CACHE_60"), function () use ($content) {
            $adItems = collect();
            if (optional($content->contentset)->id != 199) {
                $adItems = Content::whereHas("contentsets", function ($q) {
                    $q->where("id", 199);
                })
                    ->where("enable", 1)
                    ->orderBy("order")
                    ->get();
            }
            return $adItems;
        });

        return $adItems;
    }

    public function getAuthorAttribute(){
        $content = $this;
        $key = "content:author" . $content->cacheKey();
        $author = Cache::tags(["user"])->remember($key, Config::get("constants.CACHE_60"), function () use ($content) {
            return optional($this->user)->getfullName();
        });
        return isset($author) ? $author : "";
    }
    public function getMetaTags(): array
    {
        return [
                'title' => $this->metaTitle,
                'description' => $this->metaDescription,
                'url' => action('ContentController@show',$this),
                'canonical' => action('ContentController@show',$this),
                'site' => 'آلاء',
                'imageUrl' => $this->thumbnail,
                'imageWidth' => '1280',
                'imageHeight' => '720',
                'seoMod' => SeoMetaTagsGenerator::SEO_MOD_VIDEO_TAGS,
                'playerUrl' => action('ContentController@embed',$this),
                'playerWidth' => '854',
                'playerHeight' => '480',
                'videoDirectUrl' => $this->file->first()->where('res','480p')->first()->link,
                'videoActorName' => $this->author,
                'videoActorRole' => 'دبیر',
                'videoDirector' => 'آلاء',
                'videoWriter' => 'آلاء',
                'videoDuration' => $this->duration,
                'videoReleaseDate' => $this->validSince,
                'tags' => $this->tags,
                'videoWidth' => '854',
                'videoHeight' => '480',
                'videoType' => 'video/mp4',
                'articleAuthor' => $this->author,
                'articleModifiedTime' => $this->updated_at,
                'articlePublishedTime' => $this->validSince,
        ];
    }
}
