<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Attributetype
 *
 * @property int $id
 * @property string|null $name نام این نوع
 * @property string|null $description توضیح درباره این نوع
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Attributetype onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributetype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributetype whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributetype whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributetype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributetype whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attributetype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Attributetype withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Attributetype withoutTrashed()
 * @mixin \Eloquent
 */
class Attributetype extends Model
{
    use SoftDeletes;
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
        'description',
    ];

}
