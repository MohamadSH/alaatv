<?php

namespace App;

/**
 * App\Userupload
 *
 * @property int                             $id
 * @property int                             $user_id             آی دی مشخص کننده کاربر آپلود کننده فایل
 * @property string|null                     $file                فایل آپلود شده
 * @property string|null                     $title               عنوان وارد شده کاربر برای این آپلود
 * @property string|null                     $comment             توضیح وارد شده کاربر درباره آپلود
 * @property string|null                     $staffComment        توضیح مسئول درباره فایل
 * @property int                             $isEnable            فعال / غیر فعال
 * @property int|null                        $useruploadstatus_id وضعیت فایل
 * @property \Carbon\Carbon|null             $created_at
 * @property \Carbon\Carbon|null             $updated_at
 * @property \Carbon\Carbon|null             $deleted_at
 * @property-read \App\User                  $user
 * @property-read \App\Useruploadstatus|null $useruploadstatus
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Userupload onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userupload whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userupload whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userupload whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userupload whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userupload whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userupload whereIsEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userupload whereStaffComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userupload whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userupload whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userupload whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userupload whereUseruploadstatusId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Userupload withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Userupload withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userupload newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userupload newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userupload query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 */
class Userupload extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'file',
        'title',
        'comment',
        'staffComment',
        'isEnable',
        'useruploadstatus_id',
    ];

    public function useruploadstatus()
    {
        return $this->belongsTo('App\Useruploadstatus');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
