<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Userupload
 *
 * @property int                             $id
 * @property int                        $user_id             آی دی مشخص کننده کاربر آپلود کننده فایل
 * @property string|null                $file                فایل آپلود شده
 * @property string|null                $title               عنوان وارد شده کاربر برای این آپلود
 * @property string|null                $comment             توضیح وارد شده کاربر درباره آپلود
 * @property string|null                $staffComment        توضیح مسئول درباره فایل
 * @property int                        $isEnable            فعال / غیر فعال
 * @property int|null                   $useruploadstatus_id وضعیت فایل
 * @property Carbon|null        $created_at
 * @property Carbon|null        $updated_at
 * @property Carbon|null        $deleted_at
 * @property-read User                  $user
 * @property-read Useruploadstatus|null $useruploadstatus
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Userupload onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Userupload whereComment($value)
 * @method static Builder|Userupload whereCreatedAt($value)
 * @method static Builder|Userupload whereDeletedAt($value)
 * @method static Builder|Userupload whereFile($value)
 * @method static Builder|Userupload whereId($value)
 * @method static Builder|Userupload whereIsEnable($value)
 * @method static Builder|Userupload whereStaffComment($value)
 * @method static Builder|Userupload whereTitle($value)
 * @method static Builder|Userupload whereUpdatedAt($value)
 * @method static Builder|Userupload whereUserId($value)
 * @method static Builder|Userupload whereUseruploadstatusId($value)
 * @method static \Illuminate\Database\Query\Builder|Userupload withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Userupload withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Userupload newModelQuery()
 * @method static Builder|Userupload newQuery()
 * @method static Builder|Userupload query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                      $cache_cooldown_seconds
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
