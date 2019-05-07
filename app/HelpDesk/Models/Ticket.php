<?php

namespace App\HelpDesk\Models;

use App\User;
use App\BaseModel;

/**
 * App\HelpDesk\Models\Ticket
 *
 * @property-read \App\User                                                               $agent
 * @property-read \App\HelpDesk\Models\Category                                           $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\HelpDesk\Models\Comment[] $comments
 * @property-read \App\HelpDesk\Models\Priority                                           $priority
 * @property-read \App\HelpDesk\Models\Status                                             $status
 * @property-read \App\User                                                               $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Ticket agentTickets($id)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Ticket close()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Ticket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Ticket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Ticket open()
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
        'close_at',
    ];
    
    public function isClose(): bool
    {
        return (bool) $this->close_at;
    }
    
    public function scopeClose($query)
    {
        return $query->whereNotNull('close_at');
    }
    
    public function scopeOpen($query)
    {
        return $query->whereNull('close_at');
    }
    
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
    
    public function priority()
    {
        return $this->belongsTo(Priority::class, 'priority_id');
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
    
    public function comments()
    {
        return $this->hasMany(Comment::class, 'ticket_id');
    }
    
    public function scopeUserTickets($query, $id)
    {
        return $query->where('user_id', $id);
    }
    
    public function scopeAgentTickets($query, $id)
    {
        return $query->where('agent_id', $id);
    }
}
