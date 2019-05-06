<?php

namespace App\HelpDesk\Models;

use App\User;
use App\BaseModel;


class Category extends BaseModel
{
    /**
     * Indicates that this model should not be timestamped.
     *
     * @var bool
     */
    public    $timestamps = false;
    protected $table      = 'help_categories';
    protected $fillable   = ['name', 'color'];
    
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
