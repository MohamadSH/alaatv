<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Websitepage
 *
 * @property int                         $id
 * @property string                      $url         آدرس مختص این صفحه
 * @property string|null                 $displayName نام قابل نمایش این صفحه
 * @property string|null                 $description توضیح درباره صفحه
 * @property Carbon|null         $created_at
 * @property Carbon|null         $updated_at
 * @property Carbon|null         $deleted_at
 * @property-read Collection|Slideshow[] $slides
 * @property-read Collection|User[]      $userschecked
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Websitepage onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Websitepage whereCreatedAt($value)
 * @method static Builder|Websitepage whereDeletedAt($value)
 * @method static Builder|Websitepage whereDescription($value)
 * @method static Builder|Websitepage whereDisplayName($value)
 * @method static Builder|Websitepage whereId($value)
 * @method static Builder|Websitepage whereUpdatedAt($value)
 * @method static Builder|Websitepage whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|Websitepage withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Websitepage withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Websitepage newModelQuery()
 * @method static Builder|Websitepage newQuery()
 * @method static Builder|Websitepage query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                     $cache_cooldown_seconds
 * @property-read int|null                                                  $slides_count
 * @property-read int|null                                                  $userschecked_count
 */
class Websitepage extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'url',
        'displayName',
        'description',
    ];

    public function userschecked()
    {//Users that have seen this site page
        return $this->belongsToMany('\App\User', 'userseensitepages', 'websitepage_id', 'user_id');
    }

    public function slides()
    {
        return $this->hasMany('\App\Slideshow');
    }
}
