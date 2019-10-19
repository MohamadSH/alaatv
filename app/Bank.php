<?php

namespace App;

/**
 * App\Bank
 *
 * @property int                                                              $id
 * @property string|null                                                      $name        نام بانک
 * @property string|null                                                      $description توضیح درباره بانک
 * @property \Carbon\Carbon|null                                              $created_at
 * @property \Carbon\Carbon|null                                              $updated_at
 * @property \Carbon\Carbon|null                                              $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Bankaccount[] $backaccounts
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Bank onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Bank withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Bank withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bank newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bank newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bank query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                       $cache_cooldown_seconds
 * @property-read int|null $backaccounts_count
 */
class Bank extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
    ];
    
    public function backaccounts()
    {
        return $this->hasMany('\App\Bankaccount');
    }
}
