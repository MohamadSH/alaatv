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
 * @property int $id
 * @property string|null $content
 * @property string|null $html
 * @property int $user_id
 * @property int $ticket_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Comment whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Comment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Comment whereHtml($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Comment whereTicketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Comment whereUserId($value)
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
