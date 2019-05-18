<?php

namespace App\HelpDesk\Models;

use App\BaseModel;


/**
 * App\HelpDesk\Models\Priority
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\HelpDesk\Models\Ticket[] $tickets
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Priority newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Priority newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Priority query()
 * @mixin \Eloquent
 */
class Priority extends BaseModel
{
    /**
     * Indicates that this model should not be timestamped.
     *
     * @var bool
     */
    public    $timestamps = false;
    protected $table      = 'help_priorities';
    protected $fillable   = [
        'name',
        'color',
    ];
    
    /**
     * Get related tickets.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'priority_id');
    }
}
