<?php


namespace App\HelpDesk\Traits;


trait AgentTrait
{
    
    /**
     * Check if user is agent.
     *
     * @return bool
     */
    public static function isAgent($id = null)
    {
        // TODO: Implement isAgent() method.
    }
    
    /**
     * Check if user is admin.
     *
     * @return bool
     */
    public static function isAdmin()
    {
        // TODO: Implement isAdmin() method.
    }
    
    /**
     * Check if user is the assigned agent for a ticket.
     *
     * @param  int  $id  ticket id
     *
     * @return bool
     */
    public static function isAssignedAgent($id)
    {
        // TODO: Implement isAssignedAgent() method.
    }
    
    /**
     * Check if user is the owner for a ticket.
     *
     * @param  int  $id  ticket id
     *
     * @return bool
     */
    public static function isTicketOwner($id)
    {
        // TODO: Implement isTicketOwner() method.
    }
    
    /**
     * list of all agents and returning collection.
     *
     * @param        $query
     * @param  bool  $paginate
     *
     * @return bool
     *
     * @internal param int $cat_id
     */
    public function scopeAgents($query, $paginate = false)
    {
        // TODO: Implement scopeAgents() method.
    }
    
    /**
     * list of all admins and returning collection.
     *
     * @param        $query
     * @param  bool  $paginate
     *
     * @return bool
     *
     * @internal param int $cat_id
     */
    public function scopeAdmins($query, $paginate = false)
    {
        // TODO: Implement scopeAdmins() method.
    }
    
    /**
     * list of all agents and returning collection.
     *
     * @param        $query
     * @param  bool  $paginate
     *
     * @return bool
     *
     * @internal param int $cat_id
     */
    public function scopeUsers($query, $paginate = false)
    {
        // TODO: Implement scopeUsers() method.
    }
    
    /**
     * list of all agents and returning lists array of id and name.
     *
     * @param $query
     *
     * @return bool
     *
     * @internal param int $cat_id
     */
    public function scopeAgentsLists($query)
    {
        // TODO: Implement scopeAgentsLists() method.
    }
    
    /**
     * Get related categories.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories()
    {
        // TODO: Implement categories() method.
    }
    
    /**
     * Get related agent tickets (To be deprecated).
     */
    public function agentTickets($complete = false)
    {
        // TODO: Implement agentTickets() method.
    }
    
    /**
     * Get related user tickets (To be deprecated).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userTickets($complete = false)
    {
        // TODO: Implement userTickets() method.
    }
    
    public function tickets($complete = false)
    {
        // TODO: Implement tickets() method.
    }
    
    /**
     * Get related agent total tickets.
     */
    public function agentTotalTickets()
    {
        // TODO: Implement agentTotalTickets() method.
    }
    
    /**
     * Get related agent Completed tickets.
     */
    public function agentCompleteTickets()
    {
        // TODO: Implement agentCompleteTickets() method.
    }
    
    /**
     * Get related agent tickets.
     */
    public function agentOpenTickets()
    {
        // TODO: Implement agentOpenTickets() method.
    }
    
    /**
     * Get related user total tickets.
     */
    public function userTotalTickets()
    {
        // TODO: Implement userTotalTickets() method.
    }
    
    /**
     * Get related user Completed tickets.
     */
    public function userCompleteTickets()
    {
        // TODO: Implement userCompleteTickets() method.
    }
    
    /**
     * Get related user tickets.
     */
    public function userOpenTickets()
    {
        // TODO: Implement userOpenTickets() method.
    }
}