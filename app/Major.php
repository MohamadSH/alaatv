<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Major extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'majortype_id',
        'description' ,
        'enable',
        'order',
    ];


    public function users(){
        return $this->hasMany('App\User');
    }

    public function assignments(){
        return $this->belongsToMany('App\Assignment');
    }

    public function consultations(){
        return $this->belongsToMany('App\Consultation');
    }

    public function majortype(){
        return $this->belongsTo('\App\Majortype');
    }

    public function parents(){
        return $this->belongsToMany('App\Major', 'major_major', 'major2_id', 'major1_id')
            ->withPivot('relationtype_id' , 'majorCode')
            ->join('majorinterrelationtypes', 'relationtype_id', 'majorinterrelationtypes.id')
//            ->select('major1_id AS id', 'majorinterrelationtypes.name AS pivot_relationName' , 'majorinterrelationtypes.displayName AS pivot_relationDisplayName')
            ->where("relationtype_id" , 1);
    }

    public function children(){
        return $this->belongsToMany('App\Major', 'major_major', 'major1_id', 'major2_id')
            ->withPivot('relationtype_id', 'majorCode' )
            ->join('majorinterrelationtypes', 'relationtype_id', 'majorinterrelationtypes.id')
            ->where("relationtype_id" , 1);
    }

    public function accessibles(){
        return $this->belongsToMany('App\Major', 'major_major', 'major1_id', 'major2_id')
            ->withPivot('relationtype_id', 'majorCode' )
            ->join('majorinterrelationtypes', 'relationtype_id', 'majorinterrelationtypes.id')
            ->where("relationtype_id" , 2);
    }

    public function educationalcontents(){
        return $this->belongsToMany('App\Educationalcontent');
    }
}
