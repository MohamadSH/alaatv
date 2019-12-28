<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Storage;

/**
 * App\Websitesetting
 *
 * @property int                 $id
 * @property string              $setting ستون شامل تنظیمات سایت
 * @property int|null            $version ستون مشخص ککنده ورژن تنظیمات
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Websitesetting onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Websitesetting whereCreatedAt($value)
 * @method static Builder|Websitesetting whereDeletedAt($value)
 * @method static Builder|Websitesetting whereId($value)
 * @method static Builder|Websitesetting whereSetting($value)
 * @method static Builder|Websitesetting whereUpdatedAt($value)
 * @method static Builder|Websitesetting whereVersion($value)
 * @method static \Illuminate\Database\Query\Builder|Websitesetting withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Websitesetting withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Websitesetting newModelQuery()
 * @method static Builder|Websitesetting newQuery()
 * @method static Builder|Websitesetting query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed          $cache_cooldown_seconds
 * @property-read mixed          $site_logo_url
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

    public function getSiteLogoUrlAttribute()
    {
        $setting     = $this->setting;
        $diskAdapter = Storage::disk('alaaCdnSFTP')->getAdapter();
        return $diskAdapter->getUrl(optional($setting->site)->siteLogo);
    }
}
