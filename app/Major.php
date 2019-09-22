<?php

namespace App;

/**
 * App\Major
 *
 * @property int                                                               $id
 * @property string|null                                                       $name         نام رشته
 * @property int|null                                                          $majortype_id آی دی مشخص کننده نوع رشته
 * @property string|null                                                       $description  توضیح درباره رشته
 * @property int                                                               $enable       فعال بودن یا نبودن رشته
 * @property int                                                               $order        ترتیب نمایش رشته - در صورت
 *           نیاز به استفاده
 * @property \Carbon\Carbon|null                                               $created_at
 * @property \Carbon\Carbon|null                                               $updated_at
 * @property \Carbon\Carbon|null                                               $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Major[]        $accessibles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Assignment[]   $assignments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Major[]        $children
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Consultation[] $consultations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Content[]      $contents
 * @property-read \App\Majortype|null                                          $majortype
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Major[]        $parents
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[]         $users
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Major onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Major whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Major whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Major whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Major whereEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Major whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Major whereMajortypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Major whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Major whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Major whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Major withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Major withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Major newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Major newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Major query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                        $cache_cooldown_seconds
 * @property-read int|null $accessibles_count
 * @property-read int|null $assignments_count
 * @property-read int|null $children_count
 * @property-read int|null $consultations_count
 * @property-read int|null $contents_count
 * @property-read int|null $parents_count
 * @property-read int|null $users_count
 */
class Major extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'majortype_id',
        'description',
        'enable',
        'order',
    ];
    
    public function users()
    {
        return $this->hasMany('App\User');
    }
    
    public function assignments()
    {
        return $this->belongsToMany('App\Assignment');
    }
    
    public function consultations()
    {
        return $this->belongsToMany('App\Consultation');
    }
    
    public function majortype()
    {
        return $this->belongsTo('\App\Majortype');
    }
    
    public function parents()
    {
        return $this->belongsToMany('App\Major', 'major_major', 'major2_id', 'major1_id')
            ->withPivot('relationtype_id',
                'majorCode')
            ->join('majorinterrelationtypes', 'relationtype_id',
                'majorinterrelationtypes.id')//            ->select('major1_id AS id', 'majorinterrelationtypes.name AS pivot_relationName' , 'majorinterrelationtypes.displayName AS pivot_relationDisplayName')
        ->where("relationtype_id", 1);
    }
    
    public function children()
    {
        return $this->belongsToMany('App\Major', 'major_major', 'major1_id', 'major2_id')
            ->withPivot('relationtype_id',
                'majorCode')
            ->join('majorinterrelationtypes', 'relationtype_id', 'majorinterrelationtypes.id')
            ->where("relationtype_id", 1);
    }
    
    public function accessibles()
    {
        return $this->belongsToMany('App\Major', 'major_major', 'major1_id', 'major2_id')
            ->withPivot('relationtype_id',
                'majorCode')
            ->join('majorinterrelationtypes', 'relationtype_id', 'majorinterrelationtypes.id')
            ->where("relationtype_id", 2);
    }
    
    public function contents()
    {
        return $this->belongsToMany('App\Content');
    }
}
