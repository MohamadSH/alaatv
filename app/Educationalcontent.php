<?php

namespace App;

use App\Traits\Helper;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Auth;
use Illuminate\Support\Facades\Storage;

class Educationalcontent extends Model
{
    use SoftDeletes;
    use Helper;

    /**      * The attributes that should be mutated to dates.        */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'name',
        'description',
        'context',
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

    public function grades()
    {
        return $this->belongsToMany('App\Grade');
    }

    public function majors()
    {
        return $this->belongsToMany('App\Major');
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
            if (in_array(Contenttype::where("name", "exam")->get()->first()->id, $this->contenttypes->pluck("id")->toArray())) {
                $disk = Config::get('constants.DISK18_CLOUD');
            } elseif (in_array(Contenttype::where("name", "pamphlet")->get()->first()->id, $this->contenttypes->pluck("id")->toArray())) {
                $disk = Config::get('constants.DISK19_CLOUD');
            } elseif (in_array(Contenttype::where("name", "book")->get()->first()->id, $this->contenttypes->pluck("id")->toArray())) {
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
    public function getDisplayName()
    {
        try {
            $key = "content:getDisplayName"
                .$this->cacheKey();
            $c = $this;
            return Cache::remember($key,Config::get("constants.CACHE_60"),function () use($c) {
                $displayName = "";
                $contenSets = $c->contentsets->where("pivot.isDefault" , 1)->first();
                if(isset($contenSets))
                {
                    $sessionNumber = $contenSets->pivot->order;
                }
                if (isset($c->contenttype)) {
                    $displayName .=$c->contenttype->displayName." ";
                }
                $displayName .= ( isset($sessionNumber)? "جلسه ".$sessionNumber." - ":"" )." ".(isset($c->name) ? $c->name : $c->user->name);
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

    public function getFileAttribute()
    {
        if (!is_null($this->files))
            return $this->files->first();
        return null;
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

    public function getSetMates()
    {
        $contentSets = $this->contentsets->where("pivot.isDefault" , 1);
        $contentsWithSameSet = collect();
        if($contentSets->isNotEmpty())
        {
            $contentSet = $contentSets->first();
            $sameContents =  $contentSet->educationalcontents->where("enable" , 1)->sortBy("pivot.order") ;
            $sameContents->load('files');
            $sameContents->load('contenttype');

            foreach ($sameContents as $content)
            {
                $file = $content->files->where("pivot.label" , "thumbnail")->first();
                if(isset($file))
                    $thumbnailFile = $file->name;
                else
                    $thumbnailFile = "" ;

                if (isset($content->contenttype)) {
                    $myContentType = $content->contenttype->name;
                }else{
                    $myContentType ="";
                }
                $session = $content->pivot->order;
                $contentsWithSameSet->push([
                    "type"=> $myContentType ,
                    "content"=>$content ,
                    "thumbnail"=>$thumbnailFile ,
                    "session"=>$session
                ]);
            }
        }
        return $contentsWithSameSet ;
    }

//    public function setTagsAttribute($value)
//    {
//        return json_encode($value);
//    }


}
