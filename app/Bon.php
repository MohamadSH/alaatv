<?php

namespace App;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

/**
 * App\Bon
 *
 * @property int                                                          $id
 * @property string|null                                                  $name        نام بن
 * @property string|null                                                  $displayName نام قابل نمایش بن
 * @property int|null                                                     $bontype_id  آی دی مشحص کننده نوع بن
 * @property string|null                                                  $description توضیح درباره بن
 * @property int                                                          $isEnable    فعال/غیرفعال
 * @property int                                                          $order       ترتیب بن
 * @property \Carbon\Carbon|null                                          $created_at
 * @property \Carbon\Carbon|null                                          $updated_at
 * @property \Carbon\Carbon|null                                          $deleted_at
 * @property-read \App\Bontype|null                                       $bontype
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Product[] $products
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Userbon[] $userbons
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[]    $users
 * @method static \Illuminate\Database\Eloquent\Builder|Bon enable()
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Bon onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|Bon whereBontypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bon whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bon whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bon whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bon whereIsEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bon whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bon whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bon whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Bon withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Bon withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bon ofName($name)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bon query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                   $cache_cooldown_seconds
 * @property-read int|null $products_count
 * @property-read int|null $userbons_count
 * @property-read int|null $users_count
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
        'enable',
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
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed                                  $name
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfName($query, $name)
    {
        return $query->where("name", $name);
    }
}
