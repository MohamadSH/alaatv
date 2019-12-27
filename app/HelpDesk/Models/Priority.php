<?php

namespace App\HelpDesk\Models;

use App\BaseModel;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;


/**
 * App\HelpDesk\Models\Priority
 *
 * @property-read Collection|Ticket[] $tickets
 * @method static Builder|Priority newModelQuery()
 * @method static Builder|Priority newQuery()
 * @method static Builder|Priority query()
 * @mixin Eloquent
 * @property int                                                    $id
 * @property string                                                 $name
 * @property string                                                 $color
 * @property Carbon|null                                            $deleted_at
 * @property-read int|null                                          $tickets_count
 * @method static Builder|Priority whereColor($value)
 * @method static Builder|Priority whereDeletedAt($value)
 * @method static Builder|Priority whereId($value)
 * @method static Builder|Priority whereName($value)
 */
class Priority extends BaseModel
{
    /**
     * Indicates that this model should not be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    protected $table = 'help_priorities';
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
        return $this->hasMany(Ticket::class, 'priority_id');
    }
}
