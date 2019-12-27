<?php

namespace App\HelpDesk\Models;

use App\BaseModel;
use App\Collection\UserCollection;
use App\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;


/**
 * App\HelpDesk\Models\Category
 *
 * @property-read UserCollection|User[] $agents
 * @property-read Collection|Ticket[]                   $tickets
 * @method static Builder|Category newModelQuery()
 * @method static Builder|Category newQuery()
 * @method static Builder|Category query()
 * @mixin Eloquent
 * @property int                                        $id
 * @property string                                     $name
 * @property string                                     $color
 * @property Carbon|null                                $deleted_at
 * @property-read int|null                              $agents_count
 * @property-read int|null                                          $tickets_count
 * @method static Builder|Category whereColor($value)
 * @method static Builder|Category whereDeletedAt($value)
 * @method static Builder|Category whereId($value)
 * @method static Builder|Category whereName($value)
 */
class Category extends BaseModel
{
    /**
     * Indicates that this model should not be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    protected $table = 'help_categories';
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
        return $this->hasMany(Ticket::class, 'category_id');
    }

    /**
     * Get related agents.
     *
     * @return BelongsToMany
     */
    public function agents()
    {
        return $this->belongsToMany(User::class, 'help_categories_users', 'category_id', 'user_id');
    }
}
