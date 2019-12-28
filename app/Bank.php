<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Bank
 *
 * @property int                                                         $id
 * @property string|null                                                 $name        نام بانک
 * @property string|null                                                 $description توضیح درباره بانک
 * @property Carbon|null                                         $created_at
 * @property Carbon|null                                         $updated_at
 * @property Carbon|null                                         $deleted_at
 * @property-read Collection|Bankaccount[] $backaccounts
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Bank onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Bank whereCreatedAt($value)
 * @method static Builder|Bank whereDeletedAt($value)
 * @method static Builder|Bank whereDescription($value)
 * @method static Builder|Bank whereId($value)
 * @method static Builder|Bank whereName($value)
 * @method static Builder|Bank whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Bank withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Bank withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Bank newModelQuery()
 * @method static Builder|Bank newQuery()
 * @method static Builder|Bank query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                       $cache_cooldown_seconds
 * @property-read int|null                                                    $backaccounts_count
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
