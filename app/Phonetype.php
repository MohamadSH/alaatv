<?php

namespace App;

/**
 * App\Phonetype
 *
 * @property int                                                        $id
 * @property string|null                                                $displayName نام قابل نمایش این نوع
 * @property string|null                                                $name        نام این نوع در سیستم
 * @property string|null                                                $description توضیحات این نوع
 * @property int                                                        $isEnable    نوع شماره تلفن فعال است یا خیر
 * @property \Carbon\Carbon|null                                        $created_at
 * @property \Carbon\Carbon|null                                        $updated_at
 * @property \Carbon\Carbon|null                                        $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Phone[] $phones
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Phonetype onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Phonetype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Phonetype whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Phonetype whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Phonetype whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Phonetype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Phonetype whereIsEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Phonetype whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Phonetype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Phonetype withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Phonetype withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Phonetype newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Phonetype newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Phonetype query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                 $cache_cooldown_seconds
 * @property-read int|null $phones_count
 */
class Phonetype extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'displayName',
        'description',
        'isEnable',
    ];
    
    public function phones()
    {
        return $this->hasMany('\App\Phone');
    }
}
