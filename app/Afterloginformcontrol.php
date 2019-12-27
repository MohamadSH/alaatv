<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Afterloginformcontrol
 *
 * @property int                 $id
 * @property string|null         $name
 * @property string|null         $displayName
 * @property int                 $enable
 * @property int                 $order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Afterloginformcontrol onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Afterloginformcontrol whereCreatedAt($value)
 * @method static Builder|Afterloginformcontrol whereDeletedAt($value)
 * @method static Builder|Afterloginformcontrol whereDisplayName($value)
 * @method static Builder|Afterloginformcontrol whereEnable($value)
 * @method static Builder|Afterloginformcontrol whereId($value)
 * @method static Builder|Afterloginformcontrol whereName($value)
 * @method static Builder|Afterloginformcontrol whereOrder($value)
 * @method static Builder|Afterloginformcontrol whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Afterloginformcontrol withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Afterloginformcontrol withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Afterloginformcontrol newModelQuery()
 * @method static Builder|Afterloginformcontrol newQuery()
 * @method static Builder|Afterloginformcontrol query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property int|null            $control_id آی دی مشخص کننده کنترل فیلد مثلا تکس باکس
 * @property string|null         $source     مسیر سرور جهت تغذیه فیلد (مثلا تغذیه آیتم های دراپ دان)
 * @method static Builder|Afterloginformcontrol whereControlId($value)
 * @method static Builder|Afterloginformcontrol whereSource($value)
 * @property-read mixed          $cache_cooldown_seconds
 */
class Afterloginformcontrol extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'displayName',
        'order',
    ];

    public static function getFormFields()
    {
        return Afterloginformcontrol::all()
            ->where("enable", 1)
            ->sortBy("order");
    }
}
