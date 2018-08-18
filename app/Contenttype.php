<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Contenttype
 *
 * @property int $id
 * @property string|null $name نام
 * @property string|null $displayName نام قابل نمایش
 * @property string|null $description توضیح
 * @property int $order ترتیب
 * @property int $enable فعال یا غیر فعال
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Contenttype[] $children
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Educationalcontent[] $educationalcontents
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Contenttype[] $parents
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Contenttype onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contenttype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contenttype whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contenttype whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contenttype whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contenttype whereEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contenttype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contenttype whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contenttype whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contenttype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contenttype withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Contenttype withoutTrashed()
 * @mixin \Eloquent
 */
class Contenttype extends Model
{
    use SoftDeletes;

    /**      * The attributes that should be mutated to dates.        */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'name',
        'displayName',
        'description',
        'order',
        'enable',
    ];

    public function educationalcontents()
    {
        return $this->belongsToMany('App\Educationalcontent', 'educationalcontent_contenttype', 'contenttype_id', 'content_id');
    }

    public function parents()
    {
        return $this->belongsToMany('App\Contenttype', 'contenttype_contenttype', 't2_id', 't1_id')
            ->withPivot('relationtype_id')
            ->join('contenttypeinterraltions', 'relationtype_id', 'contenttypeinterraltions.id')
//            ->select('major1_id AS id', 'majorinterrelationtypes.name AS pivot_relationName' , 'majorinterrelationtypes.displayName AS pivot_relationDisplayName')
            ->where("relationtype_id", 1);
    }

    public function children()
    {
        return $this->belongsToMany('App\Contenttype', 'contenttype_contenttype', 't1_id', 't2_id')
            ->withPivot('relationtype_id')
            ->join('contenttypeinterraltions', 'relationtype_id', 'contenttypeinterraltions.id')
            ->where("relationtype_id", 1);
    }

}
