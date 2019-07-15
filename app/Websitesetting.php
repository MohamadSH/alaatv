<?php

namespace App;

use Storage;

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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Websitesetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Websitesetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Websitesetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed          $cache_cooldown_seconds
 */
class Websitesetting extends BaseModel
{
    protected $fillable = [
        'setting',
        'version',
    ];
    
    public function getSettingAttribute($value)
    {
        return json_decode($value);
    }

    public function getSiteLogoUrlAttribute(){
        $setting = $this->setting;
        $diskAdapter = Storage::disk('alaaCdnSFTP')->getAdapter();
        return   $diskAdapter->getUrl(optional($setting->site)->siteLogo);
    }
}
