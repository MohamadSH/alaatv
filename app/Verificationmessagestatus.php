<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Verificationmessagestatus
 *
 * @property int $id
 * @property string|null $name نام وضعیت
 * @property string|null $displayName نام قابل نمایش وضعیت
 * @property string|null $description توضیح درباره وضعیت
 * @property int $order ترتیب نمایش وضعیت - در صورت نیاز به استفاده
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Verificationmessage[] $verificationmessages
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Verificationmessagestatus onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Verificationmessagestatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Verificationmessagestatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Verificationmessagestatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Verificationmessagestatus whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Verificationmessagestatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Verificationmessagestatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Verificationmessagestatus whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Verificationmessagestatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Verificationmessagestatus withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Verificationmessagestatus withoutTrashed()
 * @mixin \Eloquent
 */
class Verificationmessagestatus extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'order',
    ];

    public function verificationmessages()
    {
        return $this->hasMany('App\Verificationmessage');
    }
}
