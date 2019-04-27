<?php

namespace App;

/**
 * App\Checkoutstatus
 *
 * @property int                 $id
 * @property string|null         $name        نام این وضعیت
 * @property string|null         $displayName نام قابل نمایش این وضعیت
 * @property string|null         $description توضیح این وضعیت
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null         $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Checkoutstatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Checkoutstatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Checkoutstatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Checkoutstatus whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Checkoutstatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Checkoutstatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Checkoutstatus whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Checkoutstatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Checkoutstatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Checkoutstatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed          $cache_cooldown_seconds
 */
class Checkoutstatus extends BaseModel
{
    //
}
