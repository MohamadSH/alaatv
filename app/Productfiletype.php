<?php

namespace App;

/**
 * App\Productfiletype
 *
 * @property int                                                              $id
 * @property string|null                                                      $name        نام نوع
 * @property string|null                                                      $displayName نام قابل نمایش نوع
 * @property string|null                                                      $description نام قابل نمایش نوع
 * @property \Carbon\Carbon|null                                              $created_at
 * @property \Carbon\Carbon|null                                              $updated_at
 * @property \Carbon\Carbon|null                                              $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Productfile[] $productfiles
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Productfiletype onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productfiletype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productfiletype whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productfiletype whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productfiletype whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productfiletype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productfiletype whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productfiletype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Productfiletype withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Productfiletype withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productfiletype newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productfiletype newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Productfiletype query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                       $cache_cooldown_seconds
 * @property-read int|null $productfiles_count
 */
class Productfiletype extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'displayName',
    ];
    
    /**
     * @return array
     */
    public static function makeSelectArray(): array
    {
        $productFileTypes = Productfiletype::pluck('displayName', 'id')
            ->toArray();
        $productFileTypes = array_add($productFileTypes, 0, "انتخاب کنید");
        $productFileTypes = array_sort_recursive($productFileTypes);
        
        return $productFileTypes;
    }
    
    public function productfiles()
    {
        return $this->hasMany('\App\Productfile');
    }
    
    /**
     * @return string
     * Converting Created_at field to jalali
     */
    public function validSince_Jalali()
    {
        $explodedDateTime = explode(" ", $this->validSince);
        $explodedTime     = $explodedDateTime[1];
        
        return $this->convertDate($this->validSince, "toJalali")." ".$explodedTime;
    }
}
