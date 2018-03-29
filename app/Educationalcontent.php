<?php

namespace App;

use Carbon\Carbon;
use Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;
use Auth;
use Illuminate\Support\Facades\Storage;

class Educationalcontent extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'description',
        'context',
        'order' ,
        'validSince',
        'template_id',
    ];

    public function contenttypes(){
        return $this->belongsToMany('App\Contenttype', 'educationalcontent_contenttype', 'content_id', 'contenttype_id');
    }

    public function grades(){
        return $this->belongsToMany('App\Grade');
    }

    public function majors(){
        return $this->belongsToMany('App\Major');
    }

    public function files(){
//        return $this->belongsToMany('App\File', 'educationalcontent_file', 'content_id', 'file_id')->withPivot("caption" , "label");
        return $this->belongsToMany('App\File', 'educationalcontent_file', 'content_id', 'file_id')->withPivot("caption" );
    }

    public function contentsets()
    {
        return $this->belongsToMany("\App\Contentset" , "contentset_educationalcontent","edc_id","contentset_id")->withPivot("id");
    }

    public function template()
    {
        return $this->belongsTo("\App\Template");
    }

    /**
     * @return string
     * Converting Created_at field to jalali
     */
    public function CreatedAt_Jalali(){
        $helper = new Helper();
        $explodedDateTime = explode(" " , $this->created_at);
//        $explodedTime = $explodedDateTime[1] ;
        return $helper->convertDate($this->created_at , "toJalali" );
    }

    /**
     * @return string
     * Converting Updated_at field to jalali
     */
    public function UpdatedAt_Jalali(){
        $helper = new Helper();
        $explodedDateTime = explode(" " , $this->updated_at);
//        $explodedTime = $explodedDateTime[1] ;
        return $helper->convertDate($this->updated_at , "toJalali" );
    }

    /**
     * @return string
     * Converting Created_at field to jalali
     */
    public function validSince_Jalali(){
        $helper = new Helper();
        $explodedDateTime = explode(" " , $this->validSince);
        $explodedTime = $explodedDateTime[1] ;
        return $helper->convertDate($this->validSince , "toJalali" )." ".$explodedTime;
    }

    public function fileMultiplexer($contentTypes=array())
    {
        if(!empty($contentTypes))
        {
            if (in_array(Contenttype::where("name", "exam")->get()->first()->id, $contentTypes))
            {
                $disk = Config::get('constants.DISK18_CLOUD');
            } elseif(in_array(Contenttype::where("name", "pamphlet")->get()->first()->id, $contentTypes))
            {
                $disk = Config::get('constants.DISK19_CLOUD');
            } elseif(in_array(Contenttype::where("name", "book")->get()->first()->id, $contentTypes))
            {
                $disk = Config::get('constants.DISK20_CLOUD');
            }
            if(isset($disk))
                return $disk;
            else
                return false;
        }
        else{
            if (in_array(Contenttype::where("name", "exam")->get()->first()->id, $this->contenttypes->pluck("id")->toArray()))
            {
                $disk = Config::get('constants.DISK18_CLOUD');
            } elseif(in_array(Contenttype::where("name", "pamphlet")->get()->first()->id, $this->contenttypes->pluck("id")->toArray()))
            {
                $disk = Config::get('constants.DISK19_CLOUD');
            } elseif(in_array(Contenttype::where("name", "book")->get()->first()->id, $this->contenttypes->pluck("id")->toArray()))
            {
                $disk = Config::get('constants.DISK20_CLOUD');
            }

            if(isset($disk))
            {

                $disk = Disk::where("name" , $disk)->get()->first();
                return $disk;
            }
            else
            {
                return false;
            }
        }

        return false ;
    }

    public function isValid(): bool
    {
        if($this->validSince < Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran') )
            return true;
        return false;
    }

    public function isEnable(): bool
    {
        if($this->enable )
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

    public function scopeEnable($query,$enable=1)
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
        return $query->where('validSince','<',Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'));
    }

    /**
     * Scope a query to only include EducationalContents that will come soon.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSoon($query)
    {
        return $query->where('validSince','>',Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->timezone('Asia/Tehran'));
    }

    public function contentsWithSameType( $enable = 1 , $valid = 1)
    {
        $contentsWithSameType = Educationalcontent::where("id", "<>", $this->id) ;
        if($enable) $contentsWithSameType = $contentsWithSameType->enable() ;
        if($valid) $contentsWithSameType = $contentsWithSameType->valid() ;
        $contentTypes = $this->contenttypes->pluck("id")->toArray();
        foreach ($contentTypes as $id) {
            $contentsWithSameType = $contentsWithSameType->whereHas("contenttypes", function ($q) use ($id) {
                $q->where("id", $id);
            });
        }
        return $contentsWithSameType ;
    }

    public function getDisplayName()
    {
        try{
            $displayName = "" ;
            $rootContentType = $this->contenttypes()->whereDoesntHave("parents")->get()->first();
            $childContentType = $this->contenttypes()->whereHas("parents", function ($q) use ($rootContentType) {
                $q->where("id", $rootContentType->id);
            })->get()->first();
            if(isset($rootContentType->displayName[0])) $displayName .= $rootContentType->displayName." " ;
            if(isset($this->name[0])) $displayName .= $this->name ." " ;
            if(isset($childContentType->displayName[0])) $displayName .= $childContentType->displayName . " " ;
            $displayName .= $this->displayMajors() ;
        } catch (\Exception $e){
            return $e->getMessage();
        }
        return $displayName ;
    }

    public function displayMajors()
    {
        $displayMajors = "";
        foreach($this->majors as $major )
        {
            if(count($this->majors)>1 && $major->id != $this->majors->last()->id)
                $displayMajors .= $major->name." / " ;
            else
                $displayMajors .= $major->name. " ";
        }
        return $displayMajors ;
    }

    public function getFileAttribute(){
        if(! is_null($this->files ) )
            return $this->files->first();
        return null;
    }
    public function getFilesUrl()
    {
        $files = $this->files ;
        $links = collect() ;
        foreach ($files as $file)
        {
            $url = $file->getUrl() ;
            if(isset($url[0]))
                $links->push($url);
        }
        return $links ;
    }

}
