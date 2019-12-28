<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

/**
 * App\Bon
 *
 * @property int                       $id
 * @property string|null               $name        نام بن
 * @property string|null               $displayName نام قابل نمایش بن
 * @property int|null                  $bontype_id  آی دی مشحص کننده نوع بن
 * @property string|null               $description توضیح درباره بن
 * @property int                       $isEnable    فعال/غیرفعال
 * @property int                       $order       ترتیب بن
 * @property Carbon|null               $created_at
 * @property Carbon|null               $updated_at
 * @property Carbon|null               $deleted_at
 * @property-read Bontype|null         $bontype
 * @property-read Collection|Product[] $products
 * @property-read Collection|Userbon[] $userbons
 * @property-read Collection|User[]    $users
 * @method static Builder|Bon enable()
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Bon onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Bon whereBontypeId($value)
 * @method static Builder|Bon whereCreatedAt($value)
 * @method static Builder|Bon whereDeletedAt($value)
 * @method static Builder|Bon whereDescription($value)
 * @method static Builder|Bon whereDisplayName($value)
 * @method static Builder|Bon whereId($value)
 * @method static Builder|Bon whereIsEnable($value)
 * @method static Builder|Bon whereName($value)
 * @method static Builder|Bon whereOrder($value)
 * @method static Builder|Bon whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Bon withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Bon withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Bon ofName($name)
 * @method static Builder|Bon newModelQuery()
 * @method static Builder|Bon newQuery()
 * @method static Builder|Bon query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                $cache_cooldown_seconds
 * @property-read int|null             $products_count
 * @property-read int|null             $userbons_count
 * @property-read int|null             $users_count
 */
class Bon extends BaseModel
{
    const ALAA_BON = 1;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'displayName',
        'description',
        'order',
        'isEnable',
    ];

    protected $hidden = [
        'pivot',
        'deleted_at',
        'isEnable',
        'bontype_id',
        'order',
        'created_at',
        'updated_at',
    ];

    public static function getAlaaBonDisplayName()
    {
        if (!Schema::hasTable('bons')) {
            return null;
        }

        return Cache::tags('bon')
            ->remember('getAlaaBon', config('constants.CACHE_600'), function () {
                $myBone  = Bon::where("name", config("constants.BON1"))
                    ->get();
                $bonName = null;
                if ($myBone->isNotEmpty()) {
                    $bonName = $myBone->first()->displayName;
                }

                return $bonName;
            });
    }

    public function cacheKey()
    {
        $key  = $this->getKey();
        $time = isset($this->updated_at) ? $this->updated_at->timestamp : $this->created_at->timestamp;

        return sprintf("%s-%s", //$this->getTable(),
            $key, $time);
    }

    public function products()
    {
        return $this->belongsToMany('\App\Product')
            ->withPivot('discount', 'bonPlus');
    }

    public function users()
    {
        return $this->belongsToMany('\App\User')
            ->withPivot('number');
    }

    public function userbons()
    {
        return $this->hasMany('\App\Userbon');
    }

    public function bontype()
    {
        return $this->belongsTo("\App\BonType");
    }

    public function scopeEnable($query)
    {
        return $query->where('isEnable', '=', 1);
    }

    /**
     * @param Builder $query
     * @param mixed   $name
     *
     * @return Builder
     */
    public function scopeOfName($query, $name)
    {
        return $query->where("name", $name);
    }
}
