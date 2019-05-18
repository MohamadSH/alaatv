<?php

namespace App\HelpDesk\Models;

use App\User;
use Eloquent;
use App\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use App\HelpDesk\Collection\CommentCollection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\HelpDesk\Models\Comment
 *
 * @property-read Ticket $ticket
 * @property-read User   $user
 * @method static Builder|Comment newModelQuery()
 * @method static Builder|Comment newQuery()
 * @method static Builder|Comment query()
 * @mixin Eloquent
 */
class Comment extends BaseModel
{
    protected $table = 'help_comments';
    
    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     *
     * @return CommentCollection
     */
    public function newCollection(array $models = [])
    {
        return new CommentCollection($models);
    }
    
    /**
     * Get related ticket.
     *
     * @return BelongsTo
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
    
    /**
     * Get comment owner.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
