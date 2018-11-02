<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Bank
 *
 * @property int                                                              $id
 * @property string|null                                                      $name        نام بانک
 * @property string|null                                                      $description توضیح درباره بانک
 * @property \Carbon\Carbon|null                                              $created_at
 * @property \Carbon\Carbon|null                                              $updated_at
 * @property \Carbon\Carbon|null                                              $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Bankaccount[] $backaccounts
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Bank onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bank whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bank whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bank whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bank whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bank whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bank whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Bank withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Bank withoutTrashed()
 * @mixin \Eloquent
 */
class Bank extends Model
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
        'deleted_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
    ];

    public function backaccounts()
    {
        return $this->hasMany('\App\Bankaccount');
    }
}
