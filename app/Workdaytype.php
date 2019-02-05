<?php

namespace App;

/**
 * App\Workdaytype
 *
 * @property int                 $id
 * @property string|null         $displayName نام نوع
 * @property string|null         $description توضیح درباره این نوع
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null         $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Workdaytype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Workdaytype whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Workdaytype whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Workdaytype whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Workdaytype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Workdaytype whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Workdaytype newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Workdaytype newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Workdaytype query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 */
class Workdaytype extends BaseModel
{
    //
}
