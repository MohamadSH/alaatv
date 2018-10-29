<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Websitepage
 *
 * @property int $id
 * @property string $url آدرس مختص این صفحه
 * @property string|null $displayName نام قابل نمایش این صفحه
 * @property string|null $description توضیح درباره صفحه
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Slideshow[] $slides
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $userschecked
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
 */
class Websitepage extends Model
{
    use SoftDeletes;
    /**      * The attributes that should be mutated to dates.        */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

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
