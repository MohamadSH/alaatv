<?php


namespace App\HelpDesk;


interface AgentInterface
{
    /**
     * Check if user is agent.
     *
     * @return bool
     */
    public static function isAgent($id = null);
    
    /**
     * Check if user is admin.
     *
     * @return bool
     */
    public static function isAdmin();
    
    /**
     * Check if user is the assigned agent for a ticket.
     *
     * @param  int  $id  ticket id
     *
     * @return bool
     */
    public static function isAssignedAgent($id);
    
    /**
     * Check if user is the owner for a ticket.
     *
     * @param  int  $id  ticket id
     *
     * @return bool
     */
    public static function isTicketOwner($id);
    
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
    public function scopeAgents($query, $paginate = false);
    
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
    public function scopeAdmins($query, $paginate = false);
    
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
    public function scopeUsers($query, $paginate = false);
    
    /**
     * list of all agents and returning lists array of id and name.
     *
     * @param $query
     *
     * @return bool
     *
     * @internal param int $cat_id
     */
    public function scopeAgentsLists($query);
    
    /**
     * Get related categories.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories();
    
    /**
     * Get related agent tickets (To be deprecated).
     */
    public function agentTickets($complete = false);
    
    /**
     * Get related user tickets (To be deprecated).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userTickets($complete = false);
    
    
    public function tickets($complete = false);
    
    /**
     * Get related agent total tickets.
     */
    public function agentTotalTickets();
    
    /**
     * Get related agent Completed tickets.
     */
    public function agentCompleteTickets();
    
    /**
     * Get related agent tickets.
     */
    public function agentOpenTickets();
    
    /**
     * Get related user total tickets.
     */
    public function userTotalTickets();
    
    /**
     * Get related user Completed tickets.
     */
    public function userCompleteTickets();
    
    /**
     * Get related user tickets.
     */
    public function userOpenTickets();
    
}