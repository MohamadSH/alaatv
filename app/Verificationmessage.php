<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Verificationmessage
 *
 * @property int $id
 * @property int $user_id آی دی مشخص کننده کاربر گیرنده پیام
 * @property string|null $code کد ارسال شده به کاربر
 * @property int|null $verificationmessagestatus_id وضعیت پیام
 * @property string|null $expired_at زمان انقضای کد ارسال شده
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\User $user
 * @property-read \App\Verificationmessagestatus|null $verificationmessagestatus
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Verificationmessage whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Verificationmessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Verificationmessage whereExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Verificationmessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Verificationmessage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Verificationmessage whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Verificationmessage whereVerificationmessagestatusId($value)
 * @mixin \Eloquent
 */
class Verificationmessage extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'code',
        'verificationmessagestatus_id',
        'expired_at'
    ];

    public function user()
    {
        return $this->belongsTo('\app\User');
    }

    public function verificationmessagestatus()
    {
        return $this->belongsTo('\app\Verificationmessagestatus');
    }
}
