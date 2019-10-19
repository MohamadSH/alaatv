<?php

namespace App\HelpDesk\Models;


use App\BaseModel;

/**
 * App\HelpDesk\Models\Status
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\HelpDesk\Models\Ticket[] $tickets
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Status newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Status newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Status query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $color
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read int|null $tickets_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Status whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Status whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Status whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Status whereName($value)
 */
class Status extends BaseModel
{
    /**
     * Indicates that this model should not be timestamped.
     *
     * @var bool
     */
    public    $timestamps = false;
    protected $table      = 'help_statuses';

    protected $fillable = [
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
        return $this->hasMany(Ticket::class, 'status_id');
    }
}
