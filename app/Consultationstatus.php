<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Consultationstatus
 *
 * @property int                                                               $id
 * @property string|null                                                       $name        نام وضعیت
 * @property string|null                                                       $displayName نام قابل نمایش این وضعیت
 * @property string|null                                                       $description توضیح درباره وضعیت
 * @property int                                                               $order       ترتیب نمایش وضعیت - در صورت
 *           نیاز به استفاده
 * @property \Carbon\Carbon|null                                               $created_at
 * @property \Carbon\Carbon|null                                               $updated_at
 * @property \Carbon\Carbon|null                                               $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Consultation[] $consultations
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Consultationstatus onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultationstatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultationstatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultationstatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultationstatus whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultationstatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultationstatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultationstatus whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Consultationstatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Consultationstatus withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Consultationstatus withoutTrashed()
 * @mixin \Eloquent
 */
class Consultationstatus extends Model
{
    use SoftDeletes;
    /**      * The attributes that should be mutated to dates.        */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'order',
    ];

    public function consultations()
    {
        return $this->hasMany('App\Consultation');
    }
}
