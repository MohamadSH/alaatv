<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Firebasetoken
 *
 * @property int                             user_id
 * @property int                             $id
 * @property int                             $user_id آیدی مشخص کننده کاربر صاحب توکن
 * @property string|null                     $token   توکن فایربیس
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\User                  $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Firebasetoken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Firebasetoken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Firebasetoken query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Firebasetoken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Firebasetoken whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Firebasetoken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Firebasetoken whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Firebasetoken whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Firebasetoken whereUserId($value)
 * @mixin \Eloquent
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
