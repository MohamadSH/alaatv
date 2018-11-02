<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Websitesetting
 *
 * @property int                 $id
 * @property string              $setting ستون شامل تنظیمات سایت
 * @property int|null            $version ستون مشخص ککنده ورژن تنظیمات
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Websitesetting onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Websitesetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Websitesetting whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Websitesetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Websitesetting whereSetting($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Websitesetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Websitesetting whereVersion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Websitesetting withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Websitesetting withoutTrashed()
 * @mixin \Eloquent
 */
class Websitesetting extends Model
{
    use SoftDeletes;
    /**      * The attributes that should be mutated to dates.        */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'setting',
        'version',
    ];

    public function getSettingAttribute($value)
    {
        return json_decode($value);
    }
}
