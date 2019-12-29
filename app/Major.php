<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Major
 *
 * @property int                                                               $id
 * @property string|null                    $name         نام رشته
 * @property int|null                       $majortype_id آی دی مشخص کننده نوع رشته
 * @property string|null                    $description  توضیح درباره رشته
 * @property int                            $enable       فعال بودن یا نبودن رشته
 * @property int                            $order        ترتیب نمایش رشته - در صورت
 *           نیاز به استفاده
 * @property Carbon|null            $created_at
 * @property Carbon|null            $updated_at
 * @property Carbon|null            $deleted_at
 * @property-read Collection|Major[]        $accessibles
 * @property-read Collection|Assignment[]   $assignments
 * @property-read Collection|Major[]        $children
 * @property-read Collection|Consultation[] $consultations
 * @property-read Collection|Content[]      $contents
 * @property-read Majortype|null            $majortype
 * @property-read Collection|Major[]        $parents
 * @property-read Collection|User[]         $users
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Major onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Major whereCreatedAt($value)
 * @method static Builder|Major whereDeletedAt($value)
 * @method static Builder|Major whereDescription($value)
 * @method static Builder|Major whereEnable($value)
 * @method static Builder|Major whereId($value)
 * @method static Builder|Major whereMajortypeId($value)
 * @method static Builder|Major whereName($value)
 * @method static Builder|Major whereOrder($value)
 * @method static Builder|Major whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Major withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Major withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Major newModelQuery()
 * @method static Builder|Major newQuery()
 * @method static Builder|Major query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                        $cache_cooldown_seconds
 * @property-read int|null                                                     $accessibles_count
 * @property-read int|null                                                     $assignments_count
 * @property-read int|null                                                     $children_count
 * @property-read int|null                                                     $consultations_count
 * @property-read int|null                                                     $contents_count
 * @property-read int|null                                                     $parents_count
 * @property-read int|null                                                     $users_count
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
