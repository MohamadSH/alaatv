<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contenttype extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'displayName',
        'description' ,
        'order',
        'enable',
    ];

    public function educationalcontents(){
        return $this->belongsToMany('App\Educationalcontent', 'educationalcontent_contenttype', 'contenttype_id', 'content_id');
    }

    public function parents(){
        return $this->belongsToMany('App\Contenttype', 'contenttype_contenttype', 't2_id', 't1_id')
            ->withPivot('relationtype_id' )
            ->join('contenttypeinterraltions', 'relationtype_id', 'contenttypeinterraltions.id')
//            ->select('major1_id AS id', 'majorinterrelationtypes.name AS pivot_relationName' , 'majorinterrelationtypes.displayName AS pivot_relationDisplayName')
            ->where("relationtype_id" , 1);
    }

    public function children(){
        return $this->belongsToMany('App\Contenttype', 'contenttype_contenttype', 't1_id', 't2_id')
            ->withPivot('relationtype_id' )
            ->join('contenttypeinterraltions', 'relationtype_id', 'contenttypeinterraltions.id')
            ->where("relationtype_id" , 1);
    }

}
