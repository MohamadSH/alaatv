<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Eventresult
 *
 * @property int                              $id
 * @property int                              $user_id               آی دی مشخص کننده کاربر
 * @property int                              $event_id              آی دی مشخص کننده رخداد
 * @property int|null                    $eventresultstatus_id  آیدی مشخص کننده وضعیت نتیجه
 * @property int|null                    $rank                  رتبه کاربر در کنکور
 * @property string|null                 $participationCode     شماره داوطلبی کاربر در رخداد
 * @property string|null                 $participationCodeHash هش شماره داوطلبی
 * @property string|null                 $reportFile            فایل کارنامه کاربر
 * @property int|null                    $enableReportPublish   اجازه یا عدم اجازه انتشار کارنامه و نتیجه
 * @property string|null                 $comment               نظر کاربر درباره نتیجه و رخداد
 * @property Carbon|null         $created_at
 * @property Carbon|null         $updated_at
 * @property Carbon|null         $deleted_at
 * @property-read Event                  $event
 * @property-read Eventresultstatus|null $eventresultstatus
 * @property-read User                   $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Eventresult onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Eventresult whereComment($value)
 * @method static Builder|Eventresult whereCreatedAt($value)
 * @method static Builder|Eventresult whereDeletedAt($value)
 * @method static Builder|Eventresult whereEnableReportPublish($value)
 * @method static Builder|Eventresult whereEventId($value)
 * @method static Builder|Eventresult whereEventresultstatusId($value)
 * @method static Builder|Eventresult whereId($value)
 * @method static Builder|Eventresult whereParticipationCode($value)
 * @method static Builder|Eventresult whereParticipationCodeHash($value)
 * @method static Builder|Eventresult whereRank($value)
 * @method static Builder|Eventresult whereReportFile($value)
 * @method static Builder|Eventresult whereUpdatedAt($value)
 * @method static Builder|Eventresult whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Eventresult withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Eventresult withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Eventresult newModelQuery()
 * @method static Builder|Eventresult newQuery()
 * @method static Builder|Eventresult query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
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
