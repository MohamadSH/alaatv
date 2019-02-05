<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Afterloginformcontrol
 *
 * @property int                 $id
 * @property string|null         $name
 * @property string|null         $displayName
 * @property int                 $enable
 * @property int                 $order
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Afterloginformcontrol onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Afterloginformcontrol whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Afterloginformcontrol whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Afterloginformcontrol whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Afterloginformcontrol whereEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Afterloginformcontrol whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Afterloginformcontrol whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Afterloginformcontrol whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Afterloginformcontrol whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Afterloginformcontrol withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Afterloginformcontrol withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Afterloginformcontrol newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Afterloginformcontrol newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Afterloginformcontrol query()
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
