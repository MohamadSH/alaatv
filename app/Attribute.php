<?php

namespace App;

use App\Traits\DateTrait;
use App\Traits\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Attribute
 *
 * @property int $id
 * @property int|null $attributecontrol_id آی دی مشخص کننده کنترل قابل استفاده برای صفت
 * @property string|null $name نام صفت
 * @property string|null $displayName نام قابل نمایش
 * @property string|null $description توضیح درباره صفت
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property int|null $attributetype_id آی دی مشخص کننده نوع صفت مورد نظر
 * @property-read \App\Attributecontrol|null $attributecontrol
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Attributegroup[] $attributegroups
 * @property-read \App\Attributetype|null $attributetype
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Attributevalue[] $attributevalues
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Attribute onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attribute whereAttributecontrolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attribute whereAttributetypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attribute whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attribute whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attribute whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attribute whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attribute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attribute whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attribute whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Attribute withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Attribute withoutTrashed()
 * @mixin \Eloquent
 */
class Attribute extends Model
{
    use SoftDeletes;
    use Helper;
    use DateTrait;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'displayName',
        'description',
        'attributecontrol_id',
        'attributetype_id',
    ];

    public function attributegroups()
    {
        return $this->belongsToMany('App\Attributegroup')->withTimestamps();
    }

    public function attributecontrol()
    {
        return $this->belongsTo('App\Attributecontrol');
    }

    public function attributetype()
    {
        return $this->belongsTo('App\Attributetype');
    }

    public function attributevalues()
    {
        return $this->hasMany('App\Attributevalue');
    }
}
