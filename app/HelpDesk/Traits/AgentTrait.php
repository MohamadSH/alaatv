<?php


namespace App\HelpDesk\Traits;


use App\HelpDesk\Models\Category;
use App\HelpDesk\Models\Ticket;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait AgentTrait
{
    public function scopeHelpAgents($query)
    {
        return $query->roleName(config('helpDesk.ROLE_HELP_DESK_AGENT'));
//        $query->permissionName('ticketit_agent');
    }

    public function scopeHelpAdmins($query)
    {
        return $query->roleName(config('helpDesk.ROLE_HELP_DESK_ADMIN'));
    }

    public function isHelpAgent(): bool
    {
        return $this->hasRole(config('helpDesk.ROLE_HELP_DESK_AGENT'));
    }

    public function isHelpAdmin(): bool
    {
        return $this->hasRole(config('helpDesk.ROLE_HELP_DESK_Admin'));
    }

    /**
     * Check if user is the assigned agent for a ticket.
     *
     * @param Ticket $ticket
     *
     * @return bool
     */
    public function isAssignedAgent(Ticket $ticket): bool
    {
        return ($ticket->agent_id === $this->id && $this->isHelpAdmin());
    }

    /**
     * Check if user is the owner for a ticket.
     *
     * @param Ticket $ticket
     *
     * @return bool
     */
    public function isTicketOwner(Ticket $ticket): bool
    {
        return ($this->id === $ticket->user_id);
    }

    /**
     * Get related categories.
     *
     * @return HasMany
     */
    public function helpCategories()
    {
        return $this->belongsToMany(Category::class, 'help_categories_users', 'user_id', 'category_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'user_id');
    }

    public function agentTickets()
    {
        return $this->hasMany(Ticket::class, 'agent_id');
    }

    public function closeTickets()
    {
        return $this->tickets()
            ->close();
    }

    public function agentCloseTickets()
    {
        return $this->agentTickets()
            ->close();
    }

    public function openTickets()
    {
        return $this->tickets()
            ->open();
    }

    public function agentOpenTickets()
    {
        return $this->agentTickets()
            ->open();
    }
}
