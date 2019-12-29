<?php

namespace App\HelpDesk\Models;

use App\BaseModel;
use App\HelpDesk\Collection\CommentCollection;
use App\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\HelpDesk\Models\Comment
 *
 * @property-read Ticket                     $ticket
 * @property-read User                       $user
 * @method static Builder|Comment newModelQuery()
 * @method static Builder|Comment newQuery()
 * @method static Builder|Comment query()
 * @mixin Eloquent
 * @property int                             $id
 * @property string|null                     $content
 * @property string|null                     $html
 * @property int                             $user_id
 * @property int                             $ticket_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static Builder|Comment whereContent($value)
 * @method static Builder|Comment whereCreatedAt($value)
 * @method static Builder|Comment whereDeletedAt($value)
 * @method static Builder|Comment whereHtml($value)
 * @method static Builder|Comment whereId($value)
 * @method static Builder|Comment whereTicketId($value)
 * @method static Builder|Comment whereUpdatedAt($value)
 * @method static Builder|Comment whereUserId($value)
 */
class Comment extends BaseModel
{
    protected $table = 'help_comments';

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param array $models
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
