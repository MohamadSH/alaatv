<?php

namespace App\HelpDesk\Models;

use App\User;
use App\BaseModel;

/**
 * App\HelpDesk\Models\Comment
 *
 * @property-read \App\HelpDesk\Models\Ticket $ticket
 * @property-read \App\User                   $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Comment query()
 * @mixin \Eloquent
 */
class Comment extends BaseModel
{
    protected $table = 'help_comments';
    
    /**
     * Get related ticket.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
    
    /**
     * Get comment owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
