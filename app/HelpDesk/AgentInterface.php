<?php


namespace App\HelpDesk;


use App\HelpDesk\Models\Ticket;

interface AgentInterface
{
    public function scopeHelpAgents($query);

    public function scopeHelpAdmins($query);

    public function isHelpAgent(): bool;

    public function isHelpAdmin(): bool;

    public function isAssignedAgent(Ticket $ticket): bool;

    public function isTicketOwner(Ticket $ticket): bool;

    public function helpCategories();

    public function tickets();

    public function agentTickets();

    public function closeTickets();

    public function agentCloseTickets();

    public function openTickets();

    public function agentOpenTickets();

}
