<?php

namespace App;

use Illuminate\Support\Facades\Cache;

/**
 * App\Contenttype
 *
 * @property int                                                              $id
 * @property string|null                                                      $name        نام
 * @property string|null                                                      $displayName نام قابل نمایش
 * @property string|null                                                      $description توضیح
 * @property int                                                              $order       ترتیب
 * @property int                                                              $enable      فعال یا غیر فعال
 * @property \Carbon\Carbon|null                                              $created_at
 * @property \Carbon\Carbon|null                                              $updated_at
 * @property \Carbon\Carbon|null                                              $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Contenttype[] $children
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Content[]     $contents
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Contenttype[] $parents
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Contenttype onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contenttype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contenttype whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contenttype whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contenttype whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contenttype whereEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contenttype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contenttype whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contenttype whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contenttype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contenttype withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Contenttype withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contenttype newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contenttype newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contenttype query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                       $cache_cooldown_seconds
 * @property-read int|null $children_count
 * @property-read int|null $contents_count
 * @property-read int|null $parents_count
 */
class Contenttype extends BaseModel
{
    protected $fillable = [
        'name',
        'displayName',
        'description',
        'order',
        'enable',
    ];
    
    public static function List(): array
    {
        return [
            "video",
            "pamphlet",
            "article",
        ];
    }
    
    public static function getRootContentType()
    {
        return Cache::tags('contentType')
            ->remember('ContentType:getRootContentType', config('constants.CACHE_600'), function () {
                return Contenttype::whereDoesntHave("parents")
                    ->get();
            });
    }
    
    public function contents()
    {
        return $this->belongsToMany('App\Content', 'educationalcontent_contenttype', 'contenttype_id', 'content_id');
    }
    
    public function parents()
    {
        return $this->belongsToMany('App\Contenttype', 'contenttype_contenttype', 't2_id',
            't1_id')
            ->withPivot('relationtype_id')
            ->join('contenttypeinterraltions', 'relationtype_id',
                'contenttypeinterraltions.id')//            ->select('major1_id AS id', 'majorinterrelationtypes.name AS pivot_relationName' , 'majorinterrelationtypes.displayName AS pivot_relationDisplayName')
        ->where("relationtype_id", 1);
    }
    
    public function children()
    {
        return $this->belongsToMany('App\Contenttype', 'contenttype_contenttype', 't1_id',
            't2_id')
            ->withPivot('relationtype_id')
            ->join('contenttypeinterraltions', 'relationtype_id', 'contenttypeinterraltions.id')
            ->where("relationtype_id",
                1);
    }
}
