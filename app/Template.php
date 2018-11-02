<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Template
 *
 * @property int                                                          $id
 * @property string|null                                                  $name نام
 * @property \Carbon\Carbon|null                                          $created_at
 * @property \Carbon\Carbon|null                                          $updated_at
 * @property \Carbon\Carbon|null                                          $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Content[] $contents
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Template onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Template whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Template whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Template whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Template whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Template whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Template withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Template withoutTrashed()
 * @mixin \Eloquent
 */
class Template extends Model
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
    ];

    public function contents()
    {
        return $this->hasMany('\App\Content');
    }
}
