<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Gender
 *
 * @property int                                                  $id
 * @property string|null                                          $name        نام جنیست
 * @property string|null                                          $description توضیح جنسیت
 * @property int                                                  $order       ترتیب
 * @property Carbon|null                                  $created_at
 * @property Carbon|null                                  $updated_at
 * @property Carbon|null                                  $deleted_at
 * @property-read Collection|User[] $users
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Gender onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Gender whereCreatedAt($value)
 * @method static Builder|Gender whereDeletedAt($value)
 * @method static Builder|Gender whereDescription($value)
 * @method static Builder|Gender whereId($value)
 * @method static Builder|Gender whereName($value)
 * @method static Builder|Gender whereOrder($value)
 * @method static Builder|Gender whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Gender withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Gender withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Gender newModelQuery()
 * @method static Builder|Gender newQuery()
 * @method static Builder|Gender query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                $cache_cooldown_seconds
 * @property-read int|null                                             $users_count
 */
class Gender extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'order',
    ];

    public function users()
    {
        return $this->hasMany('App\User');
    }
}
