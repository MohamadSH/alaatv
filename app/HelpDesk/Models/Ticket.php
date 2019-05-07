<?php

namespace App\HelpDesk\Models;

use App\User;
use App\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends BaseModel
{
    protected $table = 'help_tickets';
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'close_at',
    ];
    
    public function isClose(): bool
    {
        return (bool) $this->close_at;
    }
    
    /**
     * List of close tickets.
     *
     */
    public function scopeClose($query)
    {
        return $query->whereNotNull('close_at');
    }
    
    /**
     * List of active tickets.
     *
     */
    public function scopeOpen($query)
    {
        return $query->whereNull('close_at');
    }
    
    /**
     * Get Ticket status.
     *
     * @return BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
    
    /**
     * Get Ticket priority.
     *
     * @return BelongsTo
     */
    public function priority()
    {
        return $this->belongsTo(Priority::class, 'priority_id');
    }
    
    /**
     * Get Ticket category.
     *
     * @return BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    
    /**
     * Get Ticket owner.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    /**
     * Get Ticket agent.
     *
     * @return BelongsTo
     */
    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
    
    /**
     * Get Ticket comments.
     *
     * @return HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'ticket_id');
    }
    
    /**
     * Get all user tickets.
     *
     */
    public function scopeUserTickets($query, $id)
    {
        return $query->where('user_id', $id);
    }
    
    /**
     * Get all agent tickets.
     *
     */
    public function scopeAgentTickets($query, $id)
    {
        return $query->where('agent_id', $id);
    }
}
