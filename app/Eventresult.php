<?php

namespace App;

use PhpParser\Builder\Class_;

/**
 * App\Eventresult
 *
 * @property int                              $id
 * @property int                              $user_id               آی دی مشخص کننده کاربر
 * @property int                              $event_id              آی دی مشخص کننده رخداد
 * @property int|null                         $eventresultstatus_id  آیدی مشخص کننده وضعیت نتیجه
 * @property int|null                         $rank                  رتبه کاربر در کنکور
 * @property string|null                      $participationCode     شماره داوطلبی کاربر در رخداد
 * @property string|null                      $participationCodeHash هش شماره داوطلبی
 * @property string|null                      $reportFile            فایل کارنامه کاربر
 * @property int|null                         $enableReportPublish   اجازه یا عدم اجازه انتشار کارنامه و نتیجه
 * @property string|null                      $comment               نظر کاربر درباره نتیجه و رخداد
 * @property \Carbon\Carbon|null              $created_at
 * @property \Carbon\Carbon|null              $updated_at
 * @property \Carbon\Carbon|null              $deleted_at
 * @property-read \App\Event                  $event
 * @property-read \App\Eventresultstatus|null $eventresultstatus
 * @property-read \App\User                   $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Eventresult onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eventresult whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eventresult whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eventresult whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eventresult whereEnableReportPublish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eventresult whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eventresult whereEventresultstatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eventresult whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eventresult whereParticipationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eventresult whereParticipationCodeHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eventresult whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eventresult whereReportFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eventresult whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eventresult whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Eventresult withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Eventresult withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eventresult newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eventresult newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eventresult query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                       $cache_cooldown_seconds
 */
class Eventresult extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'event_id',
        'eventresultstatus_id',
        'rank',
        'participationCode',
        'participationCodeHash',
        'enableReportPublish',
        'comment',
    ];

    public function user()
    {
        return $this->belongsTo('\App\User');
    }

    public function event()
    {
        return $this->belongsTo('\App\Event');
    }

    public function eventresultstatus()
    {
        return $this->belongsTo(Eventresultstatus::Class);
    }
}
