<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Userbonstatus
 *
 * @property int                                                          $id
 * @property string|null                                                  $name        نام وضعیت
 * @property string|null                                                  $displayName نام قابل نمایش این وضعیت
 * @property string|null                                                  $description توضیح درباره وضعیت
 * @property int                                                          $order       ترتیب نمایش وضعیت - در صورت نیاز
 *           به استفاده
 * @property \Carbon\Carbon|null                                          $created_at
 * @property \Carbon\Carbon|null                                          $updated_at
 * @property string|null                                                  $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Userbon[] $userbons
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Userbonstatus onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userbonstatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userbonstatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userbonstatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userbonstatus whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userbonstatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userbonstatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userbonstatus whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Userbonstatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Userbonstatus withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Userbonstatus withoutTrashed()
 * @mixin \Eloquent
 */
class Userbonstatus extends Model
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

    public function userbons()
    {
        return $this->hasMany('App\Userbon');
    }
}
