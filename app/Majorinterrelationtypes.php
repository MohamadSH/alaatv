<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Majorinterrelationtypes
 *
 * @property int                 $id
 * @property string|null         $name        نام نوع
 * @property string|null         $displayName نام قابل نمایش نوع
 * @property string|null         $description توضیح درباره این نوع رابطه
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Majorinterrelationtypes onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Majorinterrelationtypes whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Majorinterrelationtypes whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Majorinterrelationtypes whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Majorinterrelationtypes whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Majorinterrelationtypes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Majorinterrelationtypes whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Majorinterrelationtypes whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Majorinterrelationtypes withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Majorinterrelationtypes withoutTrashed()
 * @mixin \Eloquent
 */
class Majorinterrelationtypes extends Model
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
        'displayName',
        'description',
    ];

}
