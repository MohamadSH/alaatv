<?php

namespace App;

/**
 * App\Websitepage
 *
 * @property int                                                            $id
 * @property string                                                         $url         آدرس مختص این صفحه
 * @property string|null                                                    $displayName نام قابل نمایش این صفحه
 * @property string|null                                                    $description توضیح درباره صفحه
 * @property \Carbon\Carbon|null                                            $created_at
 * @property \Carbon\Carbon|null                                            $updated_at
 * @property \Carbon\Carbon|null                                            $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Slideshow[] $slides
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[]      $userschecked
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Websitepage onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Websitepage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Websitepage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Websitepage whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Websitepage whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Websitepage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Websitepage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Websitepage whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Websitepage withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Websitepage withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Websitepage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Websitepage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Websitepage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                     $cache_cooldown_seconds
 * @property-read int|null $slides_count
 * @property-read int|null $userschecked_count
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
