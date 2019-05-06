<?php

namespace App\HelpDesk\Models;

use App\BaseModel;


class Priority extends BaseModel
{
    /**
     * Indicates that this model should not be timestamped.
     *
     * @var bool
     */
    public    $timestamps = false;
    protected $table      = 'help_priorities';
    protected $fillable   = ['name', 'color'];
    
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
