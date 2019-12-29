<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Firebasetoken
 *
 * @property int                             user_id
 * @property int                             $id
 * @property int                             $user_id آیدی مشخص کننده کاربر صاحب توکن
 * @property string|null                     $token   توکن فایربیس
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read User                       $user
 * @method static Builder|Firebasetoken newModelQuery()
 * @method static Builder|Firebasetoken newQuery()
 * @method static Builder|Firebasetoken query()
 * @method static Builder|Firebasetoken whereCreatedAt($value)
 * @method static Builder|Firebasetoken whereDeletedAt($value)
 * @method static Builder|Firebasetoken whereId($value)
 * @method static Builder|Firebasetoken whereToken($value)
 * @method static Builder|Firebasetoken whereUpdatedAt($value)
 * @method static Builder|Firebasetoken whereUserId($value)
 * @mixin Eloquent
 */
class Firebasetoken extends Model
{
    /**      * The attributes that should be mutated to dates.        */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'token',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
