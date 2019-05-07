<?php

namespace App\HelpDesk\Models;

use App\User;
use App\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\HelpDesk\Models\Ticket
 *
 * @property-read \App\User                                                               $agent
 * @property-read \App\HelpDesk\Models\Category                                           $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\HelpDesk\Models\Comment[] $comments
 * @property-read \App\HelpDesk\Models\Priority                                           $priority
 * @property-read \App\HelpDesk\Models\Status                                             $status
 * @property-read \App\User                                                               $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Ticket active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Ticket agentTickets($id)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Ticket complete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Ticket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Ticket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Ticket query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Ticket userTickets($id)
 * @mixin \Eloquent
 */
class Ticket extends BaseModel
{
    protected $table = 'help_tickets';
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'completed_at',
    ];
    
    public function isComplete(): bool
    {
        return (bool) $this->completed_at;
    }
    
    /**
     * List of completed tickets.
     *
     */
    public function scopeComplete($query)
    {
        return $query->whereNotNull('completed_at');
    }
    
    /**
     * List of active tickets.
     *
     */
    public function scopeActive($query)
    {
        return $query->whereNull('completed_at');
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
