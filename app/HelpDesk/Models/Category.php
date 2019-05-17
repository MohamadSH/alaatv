<?php

namespace App\HelpDesk\Models;

use App\BaseModel;


/**
 * App\HelpDesk\Models\Category
 *
 * @property-read \App\Collection\UserCollection|\App\User[]                             $agents
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\HelpDesk\Models\Ticket[] $tickets
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Category query()
 * @mixin \Eloquent
 */
class Category extends BaseModel
{
    use DynamicRelations;

    /**
     * Indicates that this model should not be timestamped.
     *
     * @var bool
     */
    public    $timestamps = false;
    protected $table      = 'help_categories';
    protected $fillable   = [
        'name',
        'color',
    ];
}
