<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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
 * @property Carbon|null                                              $created_at
 * @property Carbon|null                                              $updated_at
 * @property Carbon|null                                              $deleted_at
 * @property-read Collection|Contenttype[] $children
 * @property-read Collection|Content[] $contents
 * @property-read Collection|Contenttype[] $parents
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Contenttype onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Contenttype whereCreatedAt($value)
 * @method static Builder|Contenttype whereDeletedAt($value)
 * @method static Builder|Contenttype whereDescription($value)
 * @method static Builder|Contenttype whereDisplayName($value)
 * @method static Builder|Contenttype whereEnable($value)
 * @method static Builder|Contenttype whereId($value)
 * @method static Builder|Contenttype whereName($value)
 * @method static Builder|Contenttype whereOrder($value)
 * @method static Builder|Contenttype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Contenttype withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Contenttype withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Contenttype newModelQuery()
 * @method static Builder|Contenttype newQuery()
 * @method static Builder|Contenttype query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
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
            'video',
            'pamphlet',
            'article',
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
