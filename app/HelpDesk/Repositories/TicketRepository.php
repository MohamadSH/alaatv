<?php


namespace App\HelpDesk\Repositories;


use App\HelpDesk\Models\Ticket;

class TicketRepository
{
    
    public function getUserTickets(int $userId)
    {
        return Ticket::where('user_id', $userId)
            ->orWhere('agent_id', $userId)
            ->paginate(20);
    }
    
}