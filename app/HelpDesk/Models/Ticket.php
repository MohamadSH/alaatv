<?php

namespace App\HelpDesk\Models;


use App\BaseModel;
use App\HelpDesk\Collection\TicketCollection;
use App\HelpDesk\Models\Category as Category;
use App\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

/**
 * App\HelpDesk\Models\Ticket
 *
 * @property-read User                       $agent
 * @property-read Category                   $category
 * @property-read Collection|Comment[]       $comments
 * @property-read Priority                   $priority
 * @property-read Status                     $status
 * @property-read User                       $user
 * @method static Builder|Ticket agentTickets($id)
 * @method static Builder|Ticket close()
 * @method static Builder|Ticket newModelQuery()
 * @method static Builder|Ticket newQuery()
 * @method static Builder|Ticket open()
 * @method static Builder|Ticket query()
 * @method static Builder|Ticket userTickets($id)
 * @mixin Eloquent
 * @property int                             $id
 * @property string                          $subject
 * @property string|null                     $content
 * @property int                             $status_id
 * @property int                             $priority_id
 * @property int                             $user_id
 * @property int                             $agent_id
 * @property int                             $category_id
 * @property Carbon|null $close_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read int|null                   $comments_count
 * @method static Builder|Ticket whereAgentId($value)
 * @method static Builder|Ticket whereCategoryId($value)
 * @method static Builder|Ticket whereCloseAt($value)
 * @method static Builder|Ticket whereContent($value)
 * @method static Builder|Ticket whereCreatedAt($value)
 * @method static Builder|Ticket whereDeletedAt($value)
 * @method static Builder|Ticket whereId($value)
 * @method static Builder|Ticket wherePriorityId($value)
 * @method static Builder|Ticket whereStatusId($value)
 * @method static Builder|Ticket whereSubject($value)
 * @method static Builder|Ticket whereUpdatedAt($value)
 * @method static Builder|Ticket whereUserId($value)
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

    protected $fillable = [
        'subject',
        'content',
        'priority_id',
        'status_id',
        'user_id',
        'agent_id',
        'category_id',
    ];

    protected $with = [
        'comments',
        'user',
        'agent',
        'status',
        'priority',
    ];


    /**
     * Create a new Eloquent Collection instance.
     *
     * @param array $models
     *
     * @return TicketCollection
     */
    public function newCollection(array $models = [])
    {
        return new TicketCollection($models);
    }

    public function isClose(): bool
    {
        return (bool)$this->close_at;
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
