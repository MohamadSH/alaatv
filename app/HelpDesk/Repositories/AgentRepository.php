<?php


namespace App\HelpDesk\Repositories;


use App\User;

class AgentRepository
{
    public function getActiveAgent($categoryID)
    {
        return optional(optional(User::helpAgents()
                ->get())->first())->id ?? config('helpDesk.DEFAULT_AGENT_ID');
    }
}