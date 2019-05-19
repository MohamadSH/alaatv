<?php

namespace App\HelpDesk\Models;

use App\BaseModel;

/**
 * App\HelpDesk\Models\Status
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\HelpDesk\Models\Ticket[] $tickets
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Status newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Status newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Status query()
 * @mixin \Eloquent
 */
class Status extends BaseModel
{
    use DynamicRelations;

    /**
     * Indicates that this model should not be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $table = 'help_statuses';

    protected $fillable = [
        'name',
        'color',
    ];
}
