<?php

namespace App;

/**
 * App\Gender
 *
 * @property int                                                       $id
 * @property string|null                                               $name        نام جنیست
 * @property string|null                                               $description توضیح جنسیت
 * @property int                                                       $order       ترتیب
 * @property \Carbon\Carbon|null                                       $created_at
 * @property \Carbon\Carbon|null                                       $updated_at
 * @property \Carbon\Carbon|null                                       $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Gender onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Gender whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Gender whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Gender whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Gender whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Gender whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Gender whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Gender whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Gender withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Gender withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Gender newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Gender newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Gender query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                $cache_cooldown_seconds
 * @property-read int|null $users_count
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
