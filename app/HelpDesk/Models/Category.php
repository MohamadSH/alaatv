<?php

namespace App\HelpDesk\Models;

use App\User;
use App\BaseModel;


/**
 * App\HelpDesk\Models\Category
 *
 * @property-read \App\Collection\UserCollection|\App\User[]                             $agents
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\HelpDesk\Models\Ticket[] $tickets
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Category query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $color
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read int|null $agents_count
 * @property-read int|null $tickets_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Category whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpDesk\Models\Category whereName($value)
 */
class Category extends BaseModel
{
    /**
     * Indicates that this model should not be timestamped.
     *
     * @var bool
     */
    public    $timestamps = false;
    protected $table      = 'help_categories';
    protected $fillable   = [
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
        return $this->hasMany(Ticket::class, 'category_id');
    }

    /**
     * Get related agents.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function agents()
    {
        return $this->belongsToMany(User::class, 'help_categories_users', 'category_id', 'user_id');
    }
}
