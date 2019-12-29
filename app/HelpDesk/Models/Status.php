<?php

namespace App\HelpDesk\Models;


use App\BaseModel;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\HelpDesk\Models\Status
 *
 * @property-read Collection|Ticket[] $tickets
 * @method static Builder|Status newModelQuery()
 * @method static Builder|Status newQuery()
 * @method static Builder|Status query()
 * @mixin Eloquent
 * @property int                                                    $id
 * @property string                                                 $name
 * @property string                                                 $color
 * @property Carbon|null                                            $deleted_at
 * @property-read int|null                                          $tickets_count
 * @method static Builder|Status whereColor($value)
 * @method static Builder|Status whereDeletedAt($value)
 * @method static Builder|Status whereId($value)
 * @method static Builder|Status whereName($value)
 */
class Status extends BaseModel
{
    /**
     * Indicates that this model should not be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    protected $table = 'help_statuses';

    protected $fillable = [
        'name',
        'color',
    ];

    /**
     * Get related tickets.
     *
     * @return HasMany
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'status_id');
    }
}
