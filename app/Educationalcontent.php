<?php

namespace App;

use App\Classes\Advertisable;
use App\Classes\LinkGenerator;
use App\Classes\Taggable;
use App\Collection\ContentCollection;
use App\Traits\APIRequestCommon;
use App\Traits\Helper;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

/**
 * App\Educationalcontent
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educationalcontent active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educationalcontent enable($enable = 1)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Educationalcontent onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educationalcontent soon()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educationalcontent valid()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educationalcontent whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educationalcontent whereContenttypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educationalcontent whereContext($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educationalcontent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educationalcontent whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educationalcontent whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educationalcontent whereEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educationalcontent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educationalcontent whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educationalcontent whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educationalcontent whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educationalcontent whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educationalcontent whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educationalcontent whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educationalcontent whereTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educationalcontent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Educationalcontent whereValidSince($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Educationalcontent withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Educationalcontent withoutTrashed()
 * @mixin \Eloquent
 * @property-read mixed $display_name
 */
class Educationalcontent extends Model implements Advertisable, Taggable
{
    use APIRequestCommon;
    use SoftDeletes;
    use Helper;

    /**      * The attributes that should be mutated to dates.        */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

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


    public function fixFiles()
    {
        $educationalContent = $this;
        $files = collect();
        $this->timestamps = false;
        switch ($educationalContent->template->name) {
            case "video1":
                $file = $educationalContent->files->where("pivot.label", "hd")->first();
                if (isset($file)) {
                    $url = $file->name;
                    $size = $educationalContent->curlGetFileSize($url);
                    $caption = $file->pivot->caption;
                    $res = "720p";
                    $type = "video";


                    $files->push([
                        "uuid" => $file->uuid,
                        "disk" => null,
                        "url" => $url,
                        "fileName" => basename($url),
                        "size" => $size,
                        "caption" => $caption,
                        "res" => $res,
                        "type" => $type
                    ]);
                }

                $file = $educationalContent->files->where("pivot.label", "hq")->first();
                if (isset($file)) {
                    $url = $file->name;
                    $size = $educationalContent->curlGetFileSize($url);
                    $caption = $file->pivot->caption;
                    $res = "480p";
                    $type = "video";

                    $files->push([
                        "uuid" => $file->uuid,
                        "disk" => null,
                        "url" => $url,
                        "fileName" => basename($url),
                        "size" => $size,
                        "caption" => $caption,
                        "res" => $res,
                        "type" => $type
                    ]);
                }


                $file = $educationalContent->files->where("pivot.label", "240p")->first();
                if (isset($file)) {
                    $url = $file->name;
                    $size = $educationalContent->curlGetFileSize($url);
                    $caption = $file->pivot->caption;
                    $res = "240p";
                    $type = "video";

                    $files->push([
                        "uuid" => $file->uuid,
                        "disk" => null,
                        "url" => $url,
                        "fileName" => basename($url),
                        "size" => $size,
                        "caption" => $caption,
                        "res" => $res,
                        "type" => $type
                    ]);
                }


                $file = optional($educationalContent->files->where("pivot.label", "thumbnail")->first());

                $url = $file->name;
                if(isset($url))
                {
                    $size = $educationalContent->curlGetFileSize($url);
                    $type = "thumbnail";

                    $this->thumbnail = [
                        "uuid" => $file->uuid,
                        "disk" => null,
                        "url" => $url,
                        "fileName" => basename($url),
                        "size" => $size,
                        "caption" => null,
                        "res" => null,
                        "type" => $type
                    ];
                }
                break;

            case  "pamphlet1":
                $pFiles = $educationalContent->files;
                foreach ($pFiles as $file) {
                    $type = "pdf";
                    $res = null;
                    $caption = "فایل" . $file->pivot->caption;
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
                        "res" => $res,
                        "type" => $type
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
                $item->link = $l->getLinks();
//                unset($item->url);
                return $item;
            });

            return $fileCollection;
        });
    }

    /**
     * @param $value
     * @return array|null|string
     * @throws Exception
     */
    public function getThumbnailAttribute($value){
        $t = json_decode($value);
        $link = new LinkGenerator($t);
        try {
            return $link->getLinks();
        } catch (Exception $e) {
            throw $e;
        }
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

    public function fileMultiplexer($contentTypes = array())
    {
        if (!empty($contentTypes)) {
            if (in_array(Contenttype::where("name", "exam")->get()->first()->id, $contentTypes)) {
                $disk = Config::get('constants.DISK18_CLOUD');
            } elseif (in_array(Contenttype::where("name", "pamphlet")->get()->first()->id, $contentTypes)) {
                $disk = Config::get('constants.DISK19_CLOUD');
            } elseif (in_array(Contenttype::where("name", "book")->get()->first()->id, $contentTypes)) {
                $disk = Config::get('constants.DISK20_CLOUD');
            }
            if (isset($disk))
                return $disk;
            else
                return false;
        } else {
            if ($this->contenttype_id == Contenttype::where("name", "exam")->get()->first()->id ) {
                $disk = Config::get('constants.DISK18_CLOUD');
            } elseif ($this->contenttype_id == Contenttype::where("name", "pamphlet")->get()->first()->id ) {
                $disk = Config::get('constants.DISK19_CLOUD');
            } elseif ($this->contenttype_id == Contenttype::where("name", "book")->get()->first()->id ) {
                $disk = Config::get('constants.DISK20_CLOUD');
            }

            if (isset($disk)) {

                $disk = Disk::where("name", $disk)->get()->first();
                return $disk;
            } else {
                return false;
            }
        }

        return false;
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
     * Scope a query to only include enable(or disable) EducationalContents.
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
     * Scope a query to only include Valid EducationalContents.
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
     * Scope a query to only include EducationalContents that will come soon.
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
        $contentsWithSameType = Educationalcontent::where("id", "<>", $this->id);
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
        return Cache::remember($key,Config::get("constants.CACHE_60"),function () use($c) {
            $sessionNumber = -1;
            $contenSets = $c->contentsets->where("pivot.isDefault" , 1)->first();
            if(isset($contenSets)) {
                $order = $contenSets->pivot->order;
                if($order >= 0)
                    $sessionNumber = $contenSets->pivot->order;
            }
            return $sessionNumber;
        });
    }

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

    public function contenttypes()
    {
        return $this->belongsToMany('App\Contenttype', 'educationalcontent_contenttype', 'content_id', 'contenttype_id');
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
        return $this->contentsets->where("pivot.isDefault", 1)->first();
    }

    public function getSessionAttribute()
    {

        $cs = $this->contentset;
        return isset($cs) ? $cs->pivot->order : null;
    }

    public function getSetMates()
    {
        $contentSet = $this->contentset;

        $sameContents = optional($contentSet)->educationalcontents()
            ->active()
            ->get()
            ->sortBy("pivot.order")
            ->load('files')
            ->load('contenttype');

        return [
            $sameContents,
            optional($contentSet)->name,
        ];
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
        $adItems = collect();
        if ($this->contentsets->isNotEmpty() && $this->contentsets->first()->id != 199)
            $adItems = Educationalcontent::whereHas("contentsets", function ($q) {
                $q->where("id", 199);
            })
                ->where("enable", 1)
                ->orderBy("order")
                ->get();
        return $adItems;
    }

    private function curlGetFileSize($url)
    {
        return 0;
    }
}
